<?php

namespace testS\controllers;

use testS\applications\App;
use testS\components\exceptions\AccessException;
use testS\components\exceptions\BadRequestException;
use testS\components\exceptions\NotFoundException;
use testS\components\Language;
use testS\components\Operation;
use testS\models\BlockModel;
use testS\models\SectionModel;
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
     *
     * @throws AccessException
     *
     * @return array
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
                "user"       => [
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
        $_SESSION["token"] = $token;
        if ($data["isRemember"] === true) {
            setcookie("token", $token, time() + 86400 * 365 * 10, "/"); // 10 years
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

            setcookie('token', '', time() - 3600, "/");
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
     *
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function getSessions()
    {
        $this->checkUser();

        $data = $this->getData();
        if (empty($data["id"])) {
            throw new BadRequestException(
                "Incorrect request to get user sessions. Data: {data}",
                [
                    "data" => json_encode($data)
                ]
            );
        }
        $id = (int) $data["id"];

        if ($id !== App::web()->getUser()->getId()) {
            $this->checkSettingsOperation(Operation::SETTINGS_USER_VIEW_SESSIONS);
        }

        $user = (new UserModel())->byId($id)->find();
        if (!$user instanceof UserModel) {
            throw new NotFoundException(
                "Unable to find user with ID: {id}",
                [
                    "id" => $id
                ]
            );
        }

        $userSessionModels = (new UserSessionModel())
            ->byUserId($id)
            ->ordered()
            ->findAll();

        $list = [];
        foreach ($userSessionModels as $userSessionModel) {
            $parsedUserAgent = parse_user_agent($userSessionModel->get("ua"));
            $list[] = [
                "token"        => $userSessionModel->get("token"),
                "ip"           => $userSessionModel->get("ip"),
                "lastActivity" => $userSessionModel->getFormattedLastActivity(),
                "platform"     => $parsedUserAgent["platform"],
                "browser"      => $parsedUserAgent["browser"],
                "version"      => $parsedUserAgent["version"],
                "isCurrent"    => $userSessionModel->get("token") === App::web()->getUser()->getToken(),
                "isOnline"     => $userSessionModel->isOnline()
            ];
        }

        if ($id === App::web()->getUser()->getId()) {
            $canDelete = true;
        } else {
            if ($user->isOwner()) {
                $canDelete = false;
            } else {
                $canDelete = $this->hasSettingsOperation(Operation::SETTINGS_USER_DELETE_SESSIONS);
            }
        }

        return [
            "title" => Language::t("user", "sessions"),
            "labels" => [
                "token" => Language::t("user", "token"),
                "lastActivity" => Language::t("user", "lastActivity"),
                "platform" => Language::t("user", "platform"),
                "browser" => Language::t("user", "browser"),
                "online" => Language::t("user", "online"),
                "current" => Language::t("user", "current"),
                "delete" => Language::t("common", "delete"),
                "deleteAllSessions" => Language::t("user", "deleteAllSessions"),
            ],
            "list" => $list,
            "canDelete" => $canDelete
        ];
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
     * Gets Users
     *
     * @return array
     */
    public function getUsers()
    {
        $this->checkUser();
        $user = App::web()->getUser();

        $list = [
            [
                "id"               => $user->getId(),
                "name"             => $user->getName(),
                "email"            => $user->getEmail(),
                "access"           => (new UserModel())->getType($user->getType()),
                "canUpdate"        => true,
                "canDelete"        => true,
                "canViewSessions"  => true,
                "isCurrent"        => true,
            ]
        ];

        $canView = $this->hasSettingsOperation(Operation::SETTINGS_USER_VIEW);
        if ($canView === true) {
            $canUpdate = $this->hasSettingsOperation(Operation::SETTINGS_USER_UPDATE);
            $canDelete = $this->hasSettingsOperation(Operation::SETTINGS_USER_DELETE);
            $canViewSessions = $this->hasSettingsOperation(Operation::SETTINGS_USER_VIEW_SESSIONS);

            $userModels = (new UserModel())->exceptId($user->getId())->ordered()->findAll();
            foreach ($userModels as $userModel) {
                $list[] = [
                    "id"               => $userModel->getId(),
                    "name"             => $userModel->get("name"),
                    "email"            => $userModel->get("email"),
                    "access"           => $userModel->getType(),
                    "canUpdate"        => $userModel->isOwner() ? false : $canUpdate,
                    "canDelete"        => $userModel->isOwner() ? false : $canDelete,
                    "canViewSessions"  => $canViewSessions,
                    "isCurrent"        => false,
                ];
            }
        }

        return [
            "title"  => Language::t("user", "users"),
            "list"   => $list,
            "canAdd" => $this->hasSettingsOperation(Operation::SETTINGS_USER_ADD),
            "labels" => [
                "name"     => Language::t("common", "name"),
                "email"    => Language::t("common", "email"),
                "access"   => Language::t("user", "access"),
                "sessions" => Language::t("user", "sessions"),
                "edit"     => Language::t("common", "edit"),
                "delete"   => Language::t("common", "delete"),
                "add"      => Language::t("common", "add"),
            ]
        ];
    }

    /**
     * Gets user
     *
     * @throws BadRequestException
     * @throws NotFoundException
     *
     * @return array
     */
    public function getUser()
    {
        $this->checkUser();

        $data = $this->getData();
        if (empty($data["id"])) {
            throw new BadRequestException(
                "Incorrect request to get user. Data: {data}",
                [
                    "data" => json_encode($data)
                ]
            );
        }

        $id = (int)$data["id"];
        $user = App::web()->getUser();
        if ($user->getId() !== $id) {
            $this->checkSettingsOperation(Operation::SETTINGS_USER_UPDATE);

            $userModel = (new UserModel())->byId($id)->find();
            if ($userModel === null) {
                throw new NotFoundException(
                    "Unable to find user with ID: {id}",
                    [
                        "id" => $id
                    ]
                );
            }

            $name = $userModel->get("name");
            $login = $userModel->get("login");
            $email = $userModel->get("email");
            $type = $userModel->get("type");
            $userOperations = $userModel->getOperations();
            $canChangeOperations = $this->isFullAccess() && !$userModel->isOwner();
        } else {
            $name = $user->getName();
            $login = $user->getLogin();
            $email = $user->getEmail();
            $type = $user->getType();
            $userOperations = $user->getOperations();
            $canChangeOperations = false;
        }

        $operations = [];
        $operations[Operation::TYPE_SECTIONS] = $this->_getSectionOperations($userOperations);
        $operations[Operation::TYPE_BLOCKS] = $this->_getBlockOperations($userOperations);
        $operations[Operation::TYPE_SETTINGS] = $this->_getSettingsOperations($userOperations);

        return [
            "name"                => $name,
            "login"               => $login,
            "email"               => $email,
            "type"                => $type,
            "canChangeOperations" => $canChangeOperations,
            "operations"          => $operations,
        ];
    }

    /**
     * Gets section operations
     *
     * @param array $userOperations
     *
     * @return array
     */
    private function _getSectionOperations($userOperations)
    {
        $operations = [
            "title" => Language::t("section", "sections"),
            "data"  => []
        ];
        $operations["data"][Operation::ALL] = [
            "title" => Language::t("operation", "all"),
            "data"  => []
        ];
        foreach (Operation::$sectionOperations as $key => $value) {
            $operations["data"][Operation::ALL]["data"][] = [
                "title" => $value,
                "name"  => sprintf(
                    "operations.%s.%s.%s",
                    Operation::TYPE_SECTIONS,
                    Operation::ALL,
                    $key
                ),
                "value" => array_key_exists(Operation::TYPE_SECTIONS, $userOperations)
                    && array_key_exists(Operation::ALL, $userOperations[Operation::TYPE_SECTIONS])
                    && in_array($key, $userOperations[Operation::TYPE_SECTIONS][Operation::ALL])
            ];
        }

        $sections = (new SectionModel)->ordered()->withRelations()->findAll();
        if (count($sections) > 0) {
            foreach ($sections as $section) {
                $id = $section->getId();

                $operations["data"][$id] = [
                    "title" => $section->get("seoModel")->get("name"),
                    "data"  => []
                ];

                foreach (Operation::$sectionOperations as $key => $value) {
                    $operations["data"][$id]["data"][] = [
                        "title" => $value,
                        "name"  => sprintf(
                            "operations.%s.%s.%s",
                            Operation::TYPE_SECTIONS,
                            $id,
                            $key
                        ),
                        "value" => array_key_exists(Operation::TYPE_SECTIONS, $userOperations)
                            && array_key_exists($id, $userOperations[Operation::TYPE_SECTIONS])
                            && in_array($key, $userOperations[Operation::TYPE_SECTIONS][$id])
                    ];
                }
            }
        }

        return $operations;
    }

    /**
     * Gets block operations
     *
     * @param array $userOperations
     *
     * @return array
     */
    private function _getBlockOperations($userOperations)
    {
        $operations = [
            "title" => Language::t("block", "blocks"),
            "data"  => []
        ];

        foreach (BlockModel::$typeNames as $blockKey => $title) {
            switch ($blockKey) {
                case BlockModel::TYPE_TEXT:
                    $operationList = Operation::$blockTextOperations;
                    break;
                default:
                    $operationList = [];
                    break;
            }

            $operations["data"][$blockKey] = [
                "title" => $title,
                "data"  => []
            ];

            $operations["data"][$blockKey]["data"][Operation::ALL] = [
                "title" => Language::t("operation", "all"),
                "data"  => []
            ];

            foreach ($operationList as $key => $value) {
                $operations["data"][$blockKey]["data"][Operation::ALL]["data"][] = [
                    "title" => $value,
                    "name"  => sprintf(
                        "operations.%s.%s.%s.%s",
                        Operation::TYPE_BLOCKS,
                        $blockKey,
                        Operation::ALL,
                        $key
                    ),
                    "value" => array_key_exists(Operation::TYPE_BLOCKS, $userOperations)
                        && array_key_exists($blockKey, $userOperations[Operation::TYPE_BLOCKS])
                        && array_key_exists(Operation::ALL, $userOperations[Operation::TYPE_BLOCKS][$blockKey])
                        && in_array($key, $userOperations[Operation::TYPE_BLOCKS][$blockKey][Operation::ALL])
                ];
            }

            $blocks = (new BlockModel())->byContentType($blockKey)->ordered()->findAll();
            if (count($blocks) > 0) {
                foreach ($blocks as $block) {
                    $id = $block->getId();

                    $operations["data"][$blockKey]["data"][$id] = [
                        "title" => $block->get("name"),
                        "data"  => []
                    ];

                    foreach ($operationList as $key => $value) {
                        $operations["data"][$blockKey]["data"][$id]["data"][] = [
                            "title" => $value,
                            "name"  => sprintf(
                                "operations.%s.%s.%s.%s",
                                Operation::TYPE_BLOCKS,
                                $blockKey,
                                $id,
                                $key
                            ),
                            "value" => array_key_exists(Operation::TYPE_BLOCKS, $userOperations)
                                && array_key_exists($blockKey, $userOperations[Operation::TYPE_BLOCKS])
                                && array_key_exists($id, $userOperations[Operation::TYPE_BLOCKS][$blockKey])
                                && in_array($key, $userOperations[Operation::TYPE_BLOCKS][$blockKey][$id])
                        ];
                    }
                }
            }
        }

        return $operations;
    }

    /**
     * Gets settings operations
     *
     * @param array $userOperations
     *
     * @return array
     */
    private function _getSettingsOperations($userOperations)
    {
        $operations = [
            "title" => Language::t("settings", "settings"),
            "data"  => []
        ];

        foreach (Operation::$settingsOperations as $key => $value) {
            $operations["data"][] = [
                "title" => $value,
                "name"  => sprintf(
                    "operations.%s.%s",
                    Operation::TYPE_SETTINGS,
                    $key
                ),
                "value" => array_key_exists(Operation::TYPE_SETTINGS, $userOperations)
                    && in_array($key, $userOperations[Operation::TYPE_SETTINGS])
            ];
        }

        return $operations;
    }

    /**
     * Adds user
     *
     * @throws BadRequestException
     *
     * @return array
     */
    public function addUser()
    {
        $this->checkSettingsOperation(Operation::SETTINGS_USER_ADD);

        $data = $this->getData();
        if (!array_key_exists("name", $data)
            || !array_key_exists("login", $data)
            || !array_key_exists("email", $data)
            || !array_key_exists("type", $data)
            || !array_key_exists("password", $data)
            || !array_key_exists("passwordConfirm", $data)
            || strlen($data["password"]) !== 32
            || strlen($data["passwordConfirm"]) !== 32
            || !array_key_exists("operations", $data)
            || !is_array($data["operations"])
        ) {
            throw new BadRequestException(
                "Incorrect request to add user. Data: {data}",
                [
                    "data" => json_encode($data)
                ]
            );
        }

        if ($data["password"] !== $data["passwordConfirm"]) {
            return [
                "errors" => [
                    "passwordConfirm" => Language::t("user", "passwordsMatch")
                ]
            ];
        }

        $userModel = new UserModel();
        $userModel->set(
            [
                "login"    => $data["login"],
                "password" => UserModel::getPasswordHash($data["password"]),
                "type"     => $data["type"],
                "name"     => $data["name"],
                "email"    => $data["email"],
            ]
        );
        $userModel->save();

        $errors = $userModel->getParsedErrors();
        if (count($errors) > 0) {
            return [
                "errors" => $errors
            ];
        }

        $userModel->addOperations($data["operations"]);

        return [
            "result" => true,
            "users"  => $this->getUsers()
        ];
    }

    /**
     * Updates user
     *
     * @throws BadRequestException
     * @throws NotFoundException
     * @throws AccessException
     *
     * @return array
     */
    public function updateUser()
    {
        $this->checkSettingsOperation(Operation::SETTINGS_USER_UPDATE);

        $data = $this->getData();
        if (!array_key_exists("id", $data)
            || !array_key_exists("name", $data)
            || !array_key_exists("login", $data)
            || !array_key_exists("email", $data)
            || !array_key_exists("type", $data)
            || !array_key_exists("operations", $data)
            || !is_array($data["operations"])
            || !array_key_exists("isChangePassword", $data)
            || !is_bool($data["isChangePassword"])
        ) {
            throw new BadRequestException(
                "Incorrect request to add user. Data: {data}",
                [
                    "data" => json_encode($data)
                ]
            );
        }

        $userModel = (new UserModel())->byId($data["id"])->find();
        if ($userModel === null) {
            throw new NotFoundException(
                "Unable to find user by ID: {id}",
                [
                    "id" => $data["id"]
                ]
            );
        }

        if ($userModel->isOwner()
            && App::web()->getUser()->getType() !== UserModel::TYPE_OWNER
        ) {
            throw new AccessException(
                "Unable to update owner"
            );
        }

        if ($data["isChangePassword"] === true) {
            if (!array_key_exists("password", $data)
                || !array_key_exists("passwordConfirm", $data)
                || strlen($data["password"]) !== 32
                || strlen($data["passwordConfirm"]) !== 32
            ) {
                throw new BadRequestException(
                    "Incorrect passwords. Password: {password}, passwordConfirm: {passwordConfirm}",
                    [
                        "password"        => $data["password"],
                        "passwordConfirm" => $data["passwordConfirm"],
                    ]
                );
            }

            if ($data["password"] !== $data["passwordConfirm"]) {
                return [
                    "errors" => [
                        "passwordConfirm" => Language::t("user", "passwordsMatch")
                    ]
                ];
            }

            $userModel->set(
                [
                    "password" => UserModel::getPasswordHash($data["password"])
                ]
            );
        }

        $userModel->set(
            [
                "login" => $data["login"],
                "type"  => $data["type"],
                "name"  => $data["name"],
                "email" => $data["email"],
            ]
        );
        $userModel->save();

        $errors = $userModel->getParsedErrors();
        if (count($errors) > 0) {
            return [
                "errors" => $errors
            ];
        }

        $userModel->updateOperations($data["operations"]);

        return [
            "result" => true,
            "users"  => $this->getUsers()
        ];
    }

    /**
     * Deletes user
     */
    public function deleteUser()
    {
        $this->checkSettingsOperation(Operation::SETTINGS_USER_DELETE);

        $data = $this->getData();
        if (!array_key_exists("id", $data)) {
            throw new BadRequestException(
                "Incorrect request to delete user. Data: {data}",
                [
                    "data" => json_encode($data)
                ]
            );
        }

        $userModel = (new UserModel())->byId($data["id"])->find();
        if ($userModel === null) {
            throw new NotFoundException(
                "Unable to find user by ID: {id}",
                [
                    "id" => $data["id"]
                ]
            );
        }

        if ($userModel->get("type") === UserModel::TYPE_OWNER) {
            throw new AccessException("Unable to delete owner");
        }

        $userModel->delete();

        return [
            "result" => true
        ];
    }
}