<?php

namespace testS\controllers;

use testS\components\exceptions\BadRequestException;
use testS\components\exceptions\NotFoundException;
use testS\components\Language;
use testS\components\Operation;
use testS\components\ValueGenerator;
use testS\models\BlockModel;
use testS\models\DesignBlockModel;
use testS\models\DesignTextModel;
use testS\models\TextInstanceModel;
use testS\models\TextModel;

/**
 * TextController
 *
 * @package testS\controllers
 */
class TextController extends AbstractController
{

    /**
     * Gets block
     *
     * @return array
     *
     * @throws NotFoundException
     */
    public function getBlock()
    {
        $name = "";
        $type = TextModel::TYPE_DIV;
        $hasEditor = false;

        $id = (int)$this->get("id");
        if ($id === 0) {
            $this->checkBlockOperation(BlockModel::TYPE_TEXT, Operation::ALL, Operation::TEXT_ADD);
            $blockModel = new BlockModel();
        } else {
            $this->checkBlockOperation(BlockModel::TYPE_TEXT, $id, Operation::TEXT_UPDATE_SETTINGS);

            $blockModel = BlockModel::getById($id);
            $textModel = $blockModel->getContentModel(false, null, "TextModel");

            $name = $blockModel->get("name");
            $type = $textModel->get("type");
            $hasEditor = $textModel->get("hasEditor");
        }

        return [
            "id"          => $id,
            "title"       => Language::t(
                "text",
                $id === 0 ? "addBlockTitle" : "editBlockTitle"
            ),
            "description" => Language::t(
                "text",
                $id === 0 ? "addBlockDescription" : "editBlockDescription"
            ),
            "forms"       => [
                "name"      => [
                    "name"       => "name",
                    "label"      => Language::t("common", "name"),
                    "validation" => $blockModel->getValidationRulesForField("name"),
                    "value"      => $name,
                ],
                "type"      => [
                    "label" => Language::t("common", "type"),
                    "value" => $type,
                    "name"  => "type",
                    "list"  => ValueGenerator::generate(ValueGenerator::ORDERED_ARRAY, TextModel::getTypeList())
                ],
                "hasEditor" => [
                    "name"  => "hasEditor",
                    "label" => Language::t("text", "hasEditor"),
                    "value" => $hasEditor,
                ],
                "button"    => [
                    "label" => Language::t("common", $id === 0 ? "add" : "update"),
                ]
            ]
        ];
    }

    /**
     * Adds block
     *
     * @return array
     *
     * @throws BadRequestException
     */
    public function createBlock()
    {
        $this->checkBlockOperation(BlockModel::TYPE_TEXT, Operation::ALL, Operation::TEXT_ADD);

        $this->checkData(
            [
                "name"      => [self::TYPE_STRING],
                "type"      => [self::TYPE_INT],
                "hasEditor" => [self::TYPE_BOOL],
            ]
        );

        $textModel = new TextModel();
        $textModel->set(
            [
                "type"      => $this->get("type"),
                "hasEditor" => $this->get("hasEditor"),
            ]
        );
        $textModel->save();

        $textInstanceModel = new TextInstanceModel();
        $textInstanceModel->set(
            [
                "textId" => $textModel->getId()
            ]
        );
        $textInstanceModel->save();

        $blockModel = new BlockModel();
        $blockModel->set(
            [
                "name"        => $this->get("name"),
                "language"    => Language::getActiveId(),
                "contentType" => BlockModel::TYPE_TEXT,
                "contentId"   => $textModel->getId(),
            ]
        );
        $blockModel->save();

        $errors = $blockModel->getParsedErrors();
        if (count($errors) > 0) {
            $this->removeSavedData();

            return [
                "errors" => $errors
            ];
        }

        return $this->getSimpleSuccessResult();
    }

    /**
     * Updates block
     *
     * @return array
     */
    public function updateBlock()
    {
        $this->checkData(
            [
                "id"        => [self::TYPE_INT, self::NOT_EMPTY],
                "name"      => [self::TYPE_STRING],
                "type"      => [self::TYPE_INT],
                "hasEditor" => [self::TYPE_BOOL],
            ]
        );

        $this->checkBlockOperation(BlockModel::TYPE_TEXT, $this->get("id"), Operation::TEXT_UPDATE_SETTINGS);

        $blockModel = BlockModel::getById($this->get("id"));

        $textModel = $blockModel->getContentModel(false, null, "TextModel");
        $textModel->set(
            [
                "type"      => $this->get("type"),
                "hasEditor" => $this->get("hasEditor"),
            ]
        );
        $textModel->save();

        $blockModel->set(
            [
                "name" => $this->get("name"),
            ]
        );
        $blockModel->save();

        $errors = $blockModel->getParsedErrors();
        if (count($errors) > 0) {
            $this->removeSavedData();

            return [
                "errors" => $errors
            ];
        }

        $blockModel->setContent();

        return [
            "result" => true,
            "html"   => $blockModel->getHtml(),
            "css"    => $blockModel->getCss(),
            "js"     => $blockModel->getJs(),
        ];
    }

    /**
     * Deletes block
     *
     * @return array
     *
     * @throws BadRequestException
     */
    public function deleteBlock()
    {
        $this->checkData(
            [
                "id" => [self::TYPE_INT, self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(BlockModel::TYPE_TEXT, $this->get("id"), Operation::TEXT_DELETE);

        $blockModel = BlockModel::getById($this->get("id"));
        if ($blockModel->get("contentType") !== BlockModel::TYPE_TEXT) {
            throw new BadRequestException(
                "Incorrect text block to delete. ID: {id}. Block type: {type}",
                [
                    "id"   => $this->get("id"),
                    "type" => $blockModel->get("contentType"),
                ]
            );
        }

        $blockModel->delete();

        return $this->getSimpleSuccessResult();
    }

    /**
     * Duplicates text block
     *
     * @return array
     *
     * @throws BadRequestException
     */
    public function createBlockDuplication()
    {
        $this->checkData(
            [
                "id" => [self::TYPE_INT, self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(BlockModel::TYPE_TEXT, $this->get("id"), Operation::TEXT_DUPLICATE);

        $blockModel = BlockModel::getById($this->get("id"));
        if ($blockModel->get("contentType") !== BlockModel::TYPE_TEXT) {
            throw new BadRequestException(
                "Incorrect text block to duplicate. ID: {id}. Block type: {type}",
                [
                    "id"   => $this->get("id"),
                    "type" => $blockModel->get("contentType"),
                ]
            );
        }

        $duplication = $blockModel->duplicate();

        // TODO
//        $textInstanceModels = (new TextInstanceModel())->byTextId($oldModel->getId())->findAll();
//        foreach ($textInstanceModels as $textInstanceModel) {
//            $newTextInstanceModel = new TextInstanceModel();
//            $newTextInstanceModel->set([
//                "textId" => $this->getId(),
//                "text"   => $textInstanceModel->get("text")
//            ]);
//            $newTextInstanceModel->save();
//        }

        return [
            "id" => $duplication->getId()
        ];
    }

    /**
     * Gets block's design
     *
     * @return array
     *
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function getDesign()
    {
        $this->checkData(
            [
                "id" => [self::NOT_EMPTY],
            ]
        );

        $id = (int) $this->get("id");

        $this->checkBlockOperation(BlockModel::TYPE_TEXT, $id, Operation::TEXT_UPDATE_DESIGN);

        $blockModel = BlockModel::getById($id);
        $textModel = $blockModel->getContentModel(true, null, "TextModel");

        /**
         * @var DesignBlockModel $designBlockModel
         * @var DesignTextModel  $designTextModel
         */
        $cssSelector = sprintf(".block-%s", $id);
        $designBlockModel = $textModel->get("designBlockModel");
        $designTextModel = $textModel->get("designTextModel");

        return [
            "id"          => $id,
            "controller"  => "text",
            "action"      => "design",
            "title"       => Language::t("text", "designTitle"),
            "description" => Language::t("text", "designDescription"),
            "list"        => [
                [
                    "title" => Language::t("text", "designTitle"),
                    "data"  => [
                        $designBlockModel->getDesign($cssSelector),
                        $designTextModel->getDesign($cssSelector),
                    ]
                ]
            ],
            "button"     => [
                "label" => Language::t("common", "save"),
            ]
        ];
    }

    /**
     * Updates block's design
     *
     * @return array
     *
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function updateDesign()
    {
        $this->checkData(
            [
                "id"               => [self::TYPE_INT, self::NOT_EMPTY],
                "designBlockModel" => [self::TYPE_ARRAY, self::NOT_EMPTY],
                "designTextModel"  => [self::TYPE_ARRAY, self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(BlockModel::TYPE_TEXT, $this->get("id"), Operation::TEXT_UPDATE_DESIGN);

        $blockModel = BlockModel::getById($this->get("id"));
        $textModel = $blockModel->getContentModel(false, null, "TextModel");

        $textModel->set([
            "designTextModel"  => $this->get("designTextModel"),
            "designBlockModel" => $this->get("designBlockModel"),
        ]);
        $textModel->save();

        return $this->getSimpleSuccessResult();
    }

    /**
     * Gets block's content
     *
     * @return array
     *
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function getContent()
    {
        $this->checkData(
            [
                "id" => [self::NOT_EMPTY],
            ]
        );

        $id = (int) $this->get("id");

        $this->checkBlockOperation(BlockModel::TYPE_TEXT, $id, Operation::TEXT_UPDATE_CONTENT);

        $blockModel = BlockModel::getById($id);
        $textModel = $blockModel->getContentModel(false, null, "TextModel");

        $textInstanceModel = (new TextInstanceModel())->byTextId($textModel->getId())->find();
        if ($textInstanceModel === null) {
            throw new NotFoundException(
                "Unable to find TextInstanceModel by text ID: {id}",
                [
                    "id" => $textModel->getId()
                ]
            );
        }

        return [
            "id"        => $blockModel->getId(),
            "name"      => $blockModel->get("name"),
            "type"      => $textModel->get("type"),
            "hasEditor" => $textModel->get("hasEditor"),
            "text"      => [
                "name"  => "text",
                "label" => Language::t("text", "text"),
                "value" => $textInstanceModel->get("text"),
            ],
            "button"    => [
                "label" => Language::t("common", "update"),
            ]
        ];
    }

    /**
     * Updates block's content
     *
     * @return array
     *
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function updateContent()
    {
        $this->checkData(
            [
                "id"   => [self::TYPE_INT, self::NOT_EMPTY],
                "text" => [self::TYPE_STRING],
            ]
        );

        $this->checkBlockOperation(BlockModel::TYPE_TEXT, $this->get("id"), Operation::TEXT_UPDATE_CONTENT);

        $blockModel = BlockModel::getById($this->get("id"));
        $textModel = $blockModel->getContentModel(false, null, "TextModel");

        $textInstanceModel = (new TextInstanceModel())->byTextId($textModel->getId())->find();
        if ($textInstanceModel === null) {
            throw new NotFoundException(
                "Unable to find TextInstanceModel by text ID: {id}",
                [
                    "id" => $textModel->getId()
                ]
            );
        }

        $textInstanceModel->set(
            [
                "text" => $this->get("text")
            ]
        );
        $textInstanceModel->save();

        $blockModel->setContent();

        return [
            "result" => true,
            "html"   => $blockModel->getHtml(),
            "css"    => $blockModel->getCss(),
            "js"     => $blockModel->getJs(),
        ];
    }
}