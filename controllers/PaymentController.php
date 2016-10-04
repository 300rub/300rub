<?php

namespace controllers;

use testS\components\Language;

/**
 * Payment's controller
 *
 * @package controllers
 */
class PaymentController extends AbstractController
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
     * Gets guest actions
     *
     * @return string[]
     */
    protected function getGuestActions()
    {
        return [];
    }

    /**
     * Panel
     */
    public function actionPanel()
    {
        $this->json = [
            "handler"     => "payment",
            "title"       => Language::t("payment", "payment"),
            "description" => Language::t("payment", "panelDescription")
        ];
    }
}