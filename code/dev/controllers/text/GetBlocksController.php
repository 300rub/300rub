<?php

namespace ss\controllers\text;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\controllers\_abstract\AbstractBlockController;
use ss\models\blocks\block\BlockModel;

/**
 * Gets a list of blocks
 */
class GetBlocksController extends AbstractBlockController
{

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->checkUser();
        $language = App::getInstance()->getLanguage();

        $blockModels = BlockModel::model()
            ->byContentType(BlockModel::TYPE_TEXT)
            ->byLanguage($language->getActiveId())
            ->bySectionId($this->getBlockSection())
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
                'name'              => $blockModel->get('name'),
                'id'                => $blockModel->getId(),
                'canUpdateSettings' => $canUpdateSettings,
                'canUpdateDesign'   => $canUpdateDesign,
                'canUpdateContent'  => $canUpdateContent
            ];
        }

        $canAdd = $this->hasBlockOperation(
            BlockModel::TYPE_TEXT,
            Operation::ALL,
            Operation::TEXT_ADD
        );

        return [
            'title'
                => $language->getMessage('text', 'texts'),
            'description'
                => $language->getMessage('text', 'panelDescription'),
            'list'    => $list,
            'canAdd'  => $canAdd,
            'labels'      => [
                'add' => $language->getMessage('common', 'add')
            ],
        ];
    }
}
