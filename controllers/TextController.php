<?php

namespace testS\controllers;

use testS\components\exceptions\BadRequestException;
use testS\components\exceptions\ModelException;
use testS\components\exceptions\NotFoundException;
use testS\components\Language;
use testS\components\Operation;
use testS\components\ValueGenerator;
use testS\models\BlockModel;
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
     */
    public function getHtml()
    {
        // @TODO
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
                $blockModel->get("contentId"),
                Operation::TEXT_UPDATE_SETTINGS
            );
            $canUpdateDesign = $this->hasBlockOperation(
                BlockModel::TYPE_TEXT,
                $blockModel->get("contentId"),
                Operation::TEXT_UPDATE_DESIGN
            );
            $canUpdateContent = $this->hasBlockOperation(
                BlockModel::TYPE_TEXT,
                $blockModel->get("contentId"),
                Operation::TEXT_UPDATE_CONTENT
            );

            if ($canUpdateSettings === false
                && $canUpdateDesign === false
                && $canUpdateContent === false
            ) {
                continue;
            }

            $list[] = [
                "blockName"         => $blockModel->get("name"),
                "contentId"         => $blockModel->get("contentId"),
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

            $textModel = new TextModel();
            $blockModel = new BlockModel();
        } else {
            $this->checkBlockOperation(BlockModel::TYPE_TEXT, $id, Operation::TEXT_UPDATE_SETTINGS);

            $textModel = (new TextModel())->byId($id)->find();
            if ($textModel === null) {
                throw new NotFoundException(
                    "Unable to find TextModel with ID: {id}",
                    [
                        "id" => $id
                    ]
                );
            }

            $blockModel = (new BlockModel())
                ->byContentType(BlockModel::TYPE_TEXT)
                ->byContentId($textModel->getId())
                ->find();
            if ($blockModel === null) {
                throw new NotFoundException(
                    "Unable to find text BlockModel with content ID: {id}",
                    [
                        "id" => $textModel->getId()
                    ]
                );
            }

            $name = $blockModel->get("name");
            $type = $textModel->get("type");
            $hasEditor = $textModel->get("hasEditor");
        }

        return [
            "id"          => $textModel->getId(),
            "title"       => Language::t(
                "text",
                $textModel->getId() === 0 ? "addBlockTitle" : "editBlockTitle"
            ),
            "description" => Language::t(
                "text",
                $textModel->getId() === 0 ? "addBlockDescription" : "editBlockDescription"
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
                    "label" => Language::t("common", $textModel->getId() === 0 ? "add" : "update"),
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
    public function addBlock()
    {
        $this->checkBlockOperation(BlockModel::TYPE_TEXT, Operation::ALL, Operation::TEXT_ADD);

        $data = $this->getData();
        if (!array_key_exists("name", $data)
            || !array_key_exists("type", $data)
            || !array_key_exists("hasEditor", $data)
            || !is_int($data["type"])
            || !is_bool($data["hasEditor"])
        ) {
            throw new BadRequestException(
                "Incorrect request to add text block. Data: {data}",
                [
                    "data" => json_encode($data)
                ]
            );
        }

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

        return [
            "result" => true
        ];
    }

    /**
     * Updates block
     */
    public function updateBlock()
    {
        // @TODO
    }

    /**
     * Deletes block
     */
    public function deleteBlock()
    {
        // @TODO
    }

    /**
     * Gets block's design
     */
    public function getDesign()
    {
        // @TODO
    }

    /**
     * Updates block's design
     */
    public function updateDesign()
    {
        // @TODO
    }

    /**
     * Gets block's content
     */
    public function getContent()
    {
        // @TODO
    }

    /**
     * Updates block's content
     */
    public function updateContent()
    {
        // @TODO
    }
}