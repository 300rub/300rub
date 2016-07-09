<?php

namespace controllers;

use applications\App;
use models\SectionModel;
use models\GridModel;

class CommonController extends AbstractController
{

    /**
     * Layout's path
     *
     * @var string
     */
    protected $layout = "common.layout";

    /**
     * Gets model name
     *
     * @return string
     */
    protected function getModelName()
    {
        return "";
    }

    /**
     * Gets guest actions
     *
     * @return string[]
     */
    protected function getGuestActions()
    {
        return [
            "actionStructure",
            "actionError"
        ];
    }

    /**
     * Displays all page structure
     *
     * @param string $section Section's name
     */
    public function actionStructure($section = null)
    {
        $model = SectionModel::model()->byUrl($section)->with(["designBlockModel"])->find();
        if (!$model) {
            $this->render("common.empty");
        } else {
            $structure = GridModel::model()->getStructure($model);
            if (!$structure) {
                $this->render("common.empty");
            } else {
                $this->render(
                    "common.structure",
                    ["model" => $model, "structure" => $structure]
                );
            }
        }
    }

    /**
     * Displays error page
     *
     * @param string $message    Message
     * @param int    $statusCode Status
     */
    public function actionError($message, $statusCode)
    {
        header("HTTP/1.0 {$statusCode}");
        
        $this->renderPartial(
            "common.error",
            [
                "statusCode" => $statusCode,
                "message"    => str_replace("\n", "<br />", $message)
            ]
        );

        exit();
    }
}