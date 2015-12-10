<?php

namespace controllers;

use system\web\Controller;
use models\SectionModel;
use models\GridModel;

class CommonController extends Controller
{

    /**
     * @param string|null $section
     */
    public function actionStructure($section = null)
    {
        $this->layout = "common/layout";

        $model = SectionModel::model()->byUrl($section)->with(["designBlockModel"])->find();
        if (!$model) {
            $this->render("common/empty");
        } else {
            $structure = GridModel::model()->getStructure($model);
            if (!$structure) {
                $this->render("common/empty");
            } else {
                $this->render(
                    "common/structure",
                    ["model" => $model, "structure" => $structure]
                );
            }
        }
    }

    /**
     * @param string $message    сообщение
     * @param int    $statusCode статус
     * @param string $trace      уровки
     */
    public function actionError($message, $statusCode = 500, $trace = "")
    {
        $this->layout = "common/layout.layout";

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