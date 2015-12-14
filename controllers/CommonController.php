<?php

namespace controllers;

use system\web\Controller;
use models\SectionModel;
use models\GridModel;

class CommonController extends Controller
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
     * @param string $trace      Trace
     */
    public function actionError($message, $statusCode = 500, $trace = "")
    {
        header("HTTP/1.0 {$statusCode}");

        $this->renderPartial(
            "error",
            [
                "statusCode" => $statusCode,
                "message"    => str_replace("\n", "<br />", $message),
                "trace"      => str_replace("\n", "<br />", $trace)
            ]
        );
    }
}