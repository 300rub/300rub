<?php

namespace controllers;
use application\App;
use components\Db;
use components\ErrorHandler;
use components\Exception;
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
     */
    public function actionLoad()
    {
        if (
            empty($this->data["language"])
            || empty($this->data["category"])
            || empty($this->data["name"])
        ) {
            throw new Exception("Incorrect URL", ErrorHandler::STATUS_NOT_FOUND);
        }

        $helpDb = App::web()->config->helpDb;
        if (!Db::setPdo($helpDb->host, $helpDb->user, $helpDb->password, $helpDb->name)) {
            throw new Exception("Unable to connect to \"help\" database");
        }

        $language = $this->data["language"];
        $category = $this->data["category"];
        $name = $this->data["name"];
        $model = HelpModel::model()->setParams($language, $category, $name)->find();
        if ($model === null) {
            throw new Exception(
                "Unable to find content with language: {$language}, category: {$category}, name: {$name}",
                ErrorHandler::STATUS_NOT_FOUND
            );
        }

        $this->json = $model->content;
    }
}