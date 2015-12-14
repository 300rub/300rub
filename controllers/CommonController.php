<?php

namespace controllers;

use system\web\Controller;
use models\SectionModel;
use models\GridModel;

class CommonController extends Controller
{

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
     * Displays all page structure
     *
     * @param string $section Section's name
     */
    public function actionStructure($section = null)
    {
        $this->layout = "common.layout";

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
     * @param string $trace      Trace
     */
    public function actionError($message, $statusCode = 500, $trace = "")
    {
        $this->layout = "common.error";

        header("HTTP/1.0 {$statusCode}");

        $this->render(
            "error",
            [
                "statusCode" => $statusCode,
                "message"    => str_replace("\n", "<br />", $message),
                "trace"      => str_replace("\n", "<br />", $trace)
            ]
        );
    }
}