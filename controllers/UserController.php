<?php

namespace testS\controllers;

use testS\applications\App;
use testS\components\exceptions\AccessException;
use testS\components\exceptions\BadRequestException;
use testS\components\Language;
use testS\models\UserModel;
use testS\models\UserSessionModel;
use testS\components\User;

/**
 * UserController
 *
 * @package testS\controllers
 */
class UserController extends AbstractController
{

    /**
     * Gets login forms
     */
    public function getLoginForms()
    {
        if ($this->isUser()) {
            throw new AccessException(
                "Unable to get login forms because user is already in context"
            );
        }

        $model = new UserModel();

        return [
            "title" => Language::t("user", "loginTitle"),
            "forms" => [
                "user"      => [
                    "name"       => "user",
                    "type"       => self::FORM_TYPE_TEXT,
                    "label"      => Language::t("user", "user"),
                    "validation" => $model->getValidationRulesForField("login")
                ],
                "password"   => [
                    "name"       => "password",
                    "type"       => self::FORM_TYPE_PASSWORD,
                    "label"      => Language::t("user", "password"),
                    "validation" => array_merge(
                        $model->getValidationRulesForField("password"),
                        [
                            "minLength" => 3
                        ]
                    )
                ],
                "isRemember" => [
                    "name"  => "isRemember",
                    "type"  => self::FORM_TYPE_CHECKBOX,
                    "label" => Language::t("user", "isRemember"),
                ],
                "button"     => [
                    "type"       => self::FORM_TYPE_BUTTON,
                    "label"      => Language::t("user", "loginButton"),
                    "controller" => "user",
                    "action"     => "session"
                ]
            ]
        ];
    }

    /**
     * Adds user session. Sets User / Login
     *
     * Creates new record in DB, memcached record, cookie record
     *
     * @return array "result" => false for incorrect username or password, "token" in case of success
     *
     * @throws BadRequestException
     */
    public function addSession()
    {
        $data = $this->getData();

        if (empty($data["user"])
            || empty($data["password"])
            || !array_key_exists("isRemember", $data)
            || !is_string($data["user"])
            || !is_string($data["password"])
            || !is_bool($data["isRemember"])
            || strlen($data["password"]) !== 32
        ) {
            throw new BadRequestException(
                "Incorrect request for user authorization. Data: {data}",
                [
                    "data" => json_encode($data)
                ]
            );
        }

        $userModel = (new UserModel())->byLogin($data["user"])->find();
        if (!$userModel instanceof UserModel) {
            return [
                "errors" => [
                    "user" => Language::t("user", "incorrect")
                ]
            ];
        }

        if ($userModel->get("password") !== sha1($data["password"])) {
            return [
                "errors" => [
                    "password" => Language::t("user", "incorrect")
                ]
            ];
        }

        $token = md5(session_id());

        App::web()->setUser($token, $userModel);

        if ($data["isRemember"] === true) {
            setcookie("token", $token);
        }

        $userSessionModel = (new UserSessionModel())->byToken($token)->find();
        if ($userSessionModel instanceof UserSessionModel) {
            return ["token" => $token];
        }

        $userSessionModel = new UserSessionModel();
        $userSessionModel->set(
            [
                "userId" => $userModel->getId(),
                "token"  => $token,
                "ip"     => $_SERVER['REMOTE_ADDR'],
                "ua"     => $_SERVER['HTTP_USER_AGENT'],
            ]
        );
        $userSessionModel->save();

        return ["token" => $token];
    }

    /**
     * Removes user session / Logout
     *
     * Removes DB record and Memcache
     *
     * 1. If there is $data["token"] - remove session by token
     * 2. If $data is empty - remove current session (logout)
     *
     * @return array "result" => true
     *
     * @throws BadRequestException
     * @throws AccessException
     */
    public function deleteSession()
    {
        $user = App::web()->getUser();
        if (!$user instanceof User) {
            return [
                "result" => true
            ];
        }

        $data = $this->getData();
        if (!array_key_exists("token", $data)) {
            App::web()->getMemcached()->delete($user->getToken());

            setcookie('token', '', time() - 3600);
            unset($_COOKIE['token']);

            $userSessionModel = (new UserSessionModel())->byToken($user->getToken())->find();
            if ($userSessionModel instanceof UserSessionModel) {
                $userSessionModel->delete();
            }

            return [
                "result" => true
            ];
        }

        $token = $data["token"];

        if (!is_string($token)
            || strlen($token) !== 32
        ) {
            throw new BadRequestException(
                "Incorrect token: {token} to delete UserSession",
                [
                    "token" => $token
                ]
            );
        }

        $userSessionModel = (new UserSessionModel())->byToken($token)->find();
        if ($userSessionModel instanceof UserSessionModel) {
            if ($userSessionModel->get("userId") !== $user->getId()) {
                throw new AccessException(
                    "Unable to delete UserSession " .
                    "with token: {token}, ID: {id}, userId: {userId} by user with ID: {currentUserId}",
                    [
                        "token"         => $token,
                        "id"            => $userSessionModel->getId(),
                        "userId"        => $userSessionModel->get("userId"),
                        "currentUserId" => $user->getId(),
                    ]
                );
            }

            App::web()->getMemcached()->delete($token);
            $userSessionModel->delete();
        }

        return [
            "result" => true
        ];
    }

    /**
     * Gets all user sessions
     *
     * @returns array "result" => a list of sessions for current user
     */
    public function getSessions()
    {
        $this->checkUser();

        $userSessionModels = (new UserSessionModel())
            ->byUserId(App::web()->getUser()->getId())
            ->ordered()
            ->findAll();

        $list = [];
        foreach ($userSessionModels as $userSessionModel) {
            $parsedUserAgent = parse_user_agent($userSessionModel->get("ua"));
            $list[] = [
                "ip"           => $userSessionModel->get("ip"),
                "token"        => $userSessionModel->get("token"),
                "lastActivity" => $userSessionModel->getFormattedLastActivity(),
                "platform"     => $parsedUserAgent["platform"],
                "browser"      => $parsedUserAgent["browser"],
                "version"      => $parsedUserAgent["version"],
                "isCurrent"    => $userSessionModel->get("token") === App::web()->getUser()->getToken(),
                "isOnline"     => $userSessionModel->isOnline()
            ];
        }

        return ["result" => $list];
    }

    /**
     * Deletes all user sessions except current
     *
     * Removed DR record and memcached record
     *
     * @return array "result" => true
     */
    public function deleteSessions()
    {
        $this->checkUser();

        $userSessionModels = (new UserSessionModel())
            ->byUserId(App::web()->getUser()->getId())
            ->exceptToken(App::web()->getUser()->getToken())
            ->findAll();

        foreach ($userSessionModels as $userSessionModel) {
            App::web()->getMemcached()->delete($userSessionModel->get("token"));
            $userSessionModel->delete();
        }

        return [
            "result" => true
        ];
    }

    /**
     * Adds user
     */
    public function addUser()
    {
        // @TODO
    }

    /**
     * Gets user
     */
    public function getUser()
    {
        // @TODO
    }

    /**
     * Updates user
     */
    public function updateUser()
    {
        // @TODO
    }

    /**
     * Deletes user
     */
    public function deleteUser()
    {
        // @TODO
    }

    /**
     * Gets Users
     */
    public function getUsers()
    {
        // @TODO
    }
}