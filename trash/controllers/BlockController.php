<?php
//
//namespace testS\controllers;
//
//use testS\components\Language;
//use testS\models\GridModel;
//use testS\models\ImageModel;
//use testS\models\TextModel;
//
///**
// * Block's controller
// *
// * @package testS\controllers
// */
//class BlockController extends AbstractController
//{
//
//    /**
//     * Gets model name
//     *
//     * @return string
//     */
//    protected function getModelName()
//    {
//        return "";
//    }
//
//    /**
//     * Gets guest actions
//     *
//     * @return string[]
//     */
//    protected function getGuestActions()
//    {
//        return [];
//    }
//
//    /**
//     * Panel. List of block types
//     */
//    public function actionPanelList()
//    {
//        $list = [];
//
//        $this->setIsDisplayFromPage();
//        $isDisplayFromPage = $this->isDisplayFromPage();
//
//        $hasText = false;
//        $hasImage = false;
//        if ($isDisplayFromPage === true) {
//            $gridModels = GridModel::model()->bySectionId($this->data["sectionId"])->findAll();
//            foreach ($gridModels as $gridModel) {
//                switch ($gridModel->contentType) {
//                    case GridModel::TYPE_TEXT:
//                        $hasText = true;
//                        break;
//                    case GridModel::TYPE_IMAGE:
//                        $hasImage = true;
//                        break;
//                    default:
//                        break;
//                }
//                if ($gridModel->contentType === GridModel::TYPE_TEXT) {
//                    $hasText = true;
//                }
//            }
//        } else {
//            $hasText = true;
//            $hasImage = true;
//        }
//
//        if ($hasText === true) {
//            $list[] = [
//                "label"   => Language::t("text", "texts"),
//                "content" => "text.panelList",
//                "icon"    => "fa-font"
//            ];
//        }
//        if ($hasImage === true) {
//            $list[] = [
//                "label"   => Language::t("image", "images"),
//                "content" => "image.panelList",
//                "icon"    => "fa-picture-o"
//            ];
//        }
//
//        $this->json = [
//            "handler"           => "listBlock",
//            "title"             => Language::t("block", "blocks"),
//            "description"       => Language::t("block", "selectCategory"),
//            "list"              => $list,
//            "isParent"          => true,
//            "isDisplayFromPage" => $isDisplayFromPage
//        ];
//    }
//}