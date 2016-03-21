<?php

namespace controllers;

use system\web\Controller;
use system\web\Language;

/**
 * Payment's controller
 *
 * @package controllers
 */
class PaymentController extends Controller
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
            "title"       => Language::t("common", "Payment"),
            "description" => Language::t("common", "Description")
        ];
    }
}