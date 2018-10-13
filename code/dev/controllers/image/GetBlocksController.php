<?php

namespace ss\controllers\image;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;

/**
 * Gets a list of blocks
 */
class GetBlocksController extends AbstractController
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
            ->byContentType(BlockModel::TYPE_IMAGE)
            ->byLanguage($language->getActiveId())
            ->bySectionId($this->getBlockSection())
            ->findAll();

        $list = [];
        foreach ($blockModels as $blockModel) {
            $canUpdateSettings = $this->hasBlockOperation(
                BlockModel::TYPE_IMAGE,
                $blockModel->getId(),
                Operation::IMAGE_UPDATE_SETTINGS
            );
            $canUpdateDesign = $this->hasBlockOperation(
                BlockModel::TYPE_IMAGE,
                $blockModel->getId(),
                Operation::IMAGE_UPDATE_DESIGN
            );
            $canUpdateContent = $this->hasBlockOperation(
                BlockModel::TYPE_IMAGE,
                $blockModel->getId(),
                Operation::IMAGE_UPDATE_CONTENT
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
            BlockModel::TYPE_IMAGE,
            Operation::ALL,
            Operation::IMAGE_ADD
        );

        return [
            'title'   => $language->getMessage('image', 'images'),
            'description'
                => $language->getMessage('image', 'panelDescription'),
            'labels' => [
                'blockSection'
                    => $language->getMessage('block', 'blockSection'),
                'add'
                    => $language->getMessage('common', 'add'),
            ],
            'list'    => $list,
            'canAdd'  => $canAdd,
        ];
    }
}
