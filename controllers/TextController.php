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
     * Gets block's HTML
     *
     * @param int $blockId
     *
     * @return string
     */
    public function getHtml($blockId = 0)
    {
//        if ($blockId === 0) {
//            $data = $this->getData();
//            if (array_key_exists("id", $data)) {
//                $blockId = (int)$data["id"];
//            }
//        }
//
//        if ($blockId === 0) {
//            throw new BadRequestException("Block ID can not be 0");
//        }
//
//        $blockModel = (new BlockModel())->byId($blockId)->find();
//        if ($blockModel === null) {
//            throw new NotFoundException(
//                "Unable to find text BlockModel by ID: {id}",
//                [
//                    "id" => $blockId
//                ]
//            );
//        }
//
//        $textModel = $blockModel->getContentModel(true);
//        if (!$textModel instanceof TextModel) {
//            throw new BadRequestException(
//                "Block content model is not a text. ID: {id}. Block type: {type}",
//                [
//                    "id"           => $blockId,
//                    "contentClass" => get_class($textModel),
//                ]
//            );
//        }
//
//        $css = "";
//        $css .= $this->getCss($blockId, $textModel->get("designBlockModel"));
//        $css .= $this->getCss($blockId, $textModel->get("designTextModel"));

        return "";
    }

    /**
     * Gets a list of blocks
     */
    public function getBlocks()
    {
        $this->checkUser();

        $blockModels = (new BlockModel())
            ->byContentType(BlockModel::TYPE_TEXT)
            ->byLanguage(Language::getActiveId())
            ->bySectionId($this->getDisplayBlocksFromSection())
            ->findAll();

        $list = [];
        foreach ($blockModels as $blockModel) {
            $canUpdateSettings = $this->hasBlockOperation(
                BlockModel::TYPE_TEXT,
                $blockModel->getId(),
                Operation::TEXT_UPDATE_SETTINGS
            );
            $canUpdateDesign = $this->hasBlockOperation(
                BlockModel::TYPE_TEXT,
                $blockModel->getId(),
                Operation::TEXT_UPDATE_DESIGN
            );
            $canUpdateContent = $this->hasBlockOperation(
                BlockModel::TYPE_TEXT,
                $blockModel->getId(),
                Operation::TEXT_UPDATE_CONTENT
            );

            if ($canUpdateSettings === false
                && $canUpdateDesign === false
                && $canUpdateContent === false
            ) {
                continue;
            }

            $list[] = [
                "name"              => $blockModel->get("name"),
                "id"                => $blockModel->getId(),
                "canUpdateSettings" => $canUpdateSettings,
                "canUpdateDesign"   => $canUpdateDesign,
                "canUpdateContent"  => $canUpdateContent
            ];
        }

        $canAdd = $this->hasBlockOperation(
            BlockModel::TYPE_TEXT,
            Operation::ALL,
            Operation::TEXT_UPDATE_SETTINGS
        );

        return [
            "title"       => Language::t("text", "texts"),
            "description" => Language::t("text", "panelDescription"),
            "list"        => $list,
            "back"        => [
                "controller" => "block",
                "action"     => "blocks"
            ],
            "settings"    => [
                "controller" => "text",
                "action"     => "block"
            ],
            "design"      => [
                "controller" => "text",
                "action"     => "design"
            ],
            "content"     => [
                "controller" => "text",
                "action"     => "content"
            ],
            "canAdd"      => $canAdd,
        ];
    }

    /**
     * Gets block
     *
     * @return array
     *
     * @throws NotFoundException
     */
    public function getBlock()
    {
        $id = 0;
        $name = "";
        $type = TextModel::TYPE_DIV;
        $hasEditor = false;

        $data = $this->getData();
        if (array_key_exists("id", $data)) {
            $id = (int)$data["id"];
        }

        if ($id === 0) {
            $this->checkBlockOperation(BlockModel::TYPE_TEXT, Operation::ALL, Operation::TEXT_ADD);
            $blockModel = new BlockModel();
        } else {
            $this->checkBlockOperation(BlockModel::TYPE_TEXT, $id, Operation::TEXT_UPDATE_SETTINGS);

            $blockModel = BlockModel::getById($id);

            $textModel = $blockModel->getContentModel();

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
            "back"        => [
                "controller" => "text",
                "action"     => "blocks"
            ],
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

        $data = $this->getData();

        $textModel = new TextModel();
        $textModel->set(
            [
                "type"      => $data["type"],
                "hasEditor" => $data["hasEditor"],
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
                "name"        => $data["name"],
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
     *
     * @throws BadRequestException
     * @throws NotFoundException
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

        $data = $this->getData();

        $this->checkBlockOperation(BlockModel::TYPE_TEXT, $data["id"], Operation::TEXT_UPDATE_SETTINGS);

        $blockModel = BlockModel::getById($data["id"]);

        $textModel = $blockModel->getContentModel();
        $textModel->set(
            [
                "type"      => $data["type"],
                "hasEditor" => $data["hasEditor"],
            ]
        );
        $textModel->save();

        $blockModel->set(
            [
                "name" => $data["name"],
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
     * Deletes block
     *
     * @return array
     *
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function deleteBlock()
    {
        $this->checkData(
            [
                "id" => [self::TYPE_INT, self::NOT_EMPTY],
            ]
        );

        $data = $this->getData();

        $this->checkBlockOperation(BlockModel::TYPE_TEXT, $data["id"], Operation::TEXT_DELETE);

        $blockModel = BlockModel::getById($data["id"]);

        if ($blockModel->get("contentType") !== BlockModel::TYPE_TEXT) {
            throw new BadRequestException(
                "Incorrect text block to delete. ID: {id}. Block type: {type}",
                [
                    "id"   => $data["id"],
                    "type" => $blockModel->get("contentType"),
                ]
            );
        }

        $blockModel->delete();

        return $this->getSimpleSuccessResult();
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

        $data = $this->getData();
        $id = (int)$data["id"];

        $this->checkBlockOperation(BlockModel::TYPE_TEXT, $data["id"], Operation::TEXT_UPDATE_DESIGN);

        $blockModel = BlockModel::getById($data["id"]);

        $textModel = $blockModel->getContentModel(true);
        if (!$textModel instanceof TextModel) {
            throw new BadRequestException(
                "Block content model is not a text. ID: {id}. Block type: {type}",
                [
                    "id"           => $data["id"],
                    "contentClass" => get_class($textModel),
                ]
            );
        }

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

        $data = $this->getData();

        $this->checkBlockOperation(BlockModel::TYPE_TEXT, $data["id"], Operation::TEXT_UPDATE_DESIGN);

        $blockModel = BlockModel::getById($data["id"]);

        $textModel = $blockModel->getContentModel();
        if (!$textModel instanceof TextModel) {
            throw new BadRequestException(
                "Block content model is not a text. ID: {id}. Block type: {type}",
                [
                    "id"           => $data["id"],
                    "contentClass" => get_class($textModel),
                ]
            );
        }

        $textModel->set([
            "designTextModel"  => $data["designTextModel"],
            "designBlockModel" => $data["designBlockModel"],
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

        $data = $this->getData();
        $id = (int) $data["id"];

        $this->checkBlockOperation(BlockModel::TYPE_TEXT, $id, Operation::TEXT_UPDATE_CONTENT);

        $blockModel = BlockModel::getById($id);

        $textModel = $blockModel->getContentModel();
        if (!$textModel instanceof TextModel) {
            throw new BadRequestException(
                "Block content model is not a text. ID: {id}. Block type: {type}",
                [
                    "id"           => $data["id"],
                    "contentClass" => get_class($textModel),
                ]
            );
        }

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

        $data = $this->getData();

        $this->checkBlockOperation(BlockModel::TYPE_TEXT, $data["id"], Operation::TEXT_UPDATE_CONTENT);

        $blockModel = BlockModel::getById($data["id"]);

        $textModel = $blockModel->getContentModel();
        if (!$textModel instanceof TextModel) {
            throw new BadRequestException(
                "Block content model is not a text. ID: {id}. Block type: {type}",
                [
                    "id"           => $data["id"],
                    "contentClass" => get_class($textModel),
                ]
            );
        }

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
                "text" => $data["text"]
            ]
        );
        $textInstanceModel->save();

        return [
            "result" => true,
            "html"   => $this->getHtml($blockModel->getId())
        ];
    }
}