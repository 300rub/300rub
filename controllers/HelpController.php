<?php

namespace controllers;

use testS\applications\App;
use components\Db;
use components\exceptions\ContentException;
use components\exceptions\DbException;
use components\Language;
use models\HelpModel;

/**
 * Help controller
 *
 * @package controllers
 */
class HelpController extends AbstractController
{

    /**
     * Gets model name
     *
     * @return string
     */
    protected function getModelName()
    {
        return "HelpModel";
    }

    /**
     * Gets guest actions
     *
     * @return string[]
     */
    protected function getGuestActions()
    {
        return [];
    }

    /**
     * Action load
     * 
     * @throws ContentException
     */
    public function actionLoad()
    {
        if (empty($this->data["category"]) || empty($this->data["name"])) {
            throw new ContentException("Unable to find category or name in content");
        }

        $helpDb = App::web()->config->helpDb;
        if (!Db::setPdo($helpDb->host, $helpDb->user, $helpDb->password, $helpDb->name)) {
            throw new DbException("Unable to connect to \"help\" database");
        }

        $language = Language::getActiveAlias();
        $category = $this->data["category"];
        $name = $this->data["name"];
        $model = HelpModel::model()->setParams($language, $category, $name)->find();
        if ($model === null) {
            throw new ContentException(
                "Unable to find content with language: {language}, category: {category}, name: {name}",
                [
                    "language" => $language,
                    "category" => $category,
                    "name"     => $name
                ]
            );
        }

        $this->json = [
            "content" => $model->content
        ];
    }
}