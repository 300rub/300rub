<?php

namespace testS\controllers\image;

use testS\application\App;
use testS\application\components\Operation;
use testS\controllers\_abstract\AbstractController;
use testS\models\blocks\block\BlockModel;

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

        $language = App::web()->getLanguage();

        $blockModels = new BlockModel();
        $blockModels
            ->byContentType(BlockModel::TYPE_IMAGE)
            ->byLanguage($language->getActiveId())
            ->bySectionId($this->getBlockSection());
        $blockModels = $blockModels->findAll();

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
            'title'
                => $language->getMessage('image', 'images'),
            'description'
                => $language->getMessage('image', 'panelDescription'),
            'list'        => $list,
            'back'        => [
                'controller' => 'block',
                'action'     => 'blocks'
            ],
            'settings'    => [
                'controller' => 'image',
                'action'     => 'block'
            ],
            'design'      => [
                'controller' => 'image',
                'action'     => 'design'
            ],
            'content'     => [
                'controller' => 'image',
                'action'     => 'content'
            ],
            'canAdd'      => $canAdd,
        ];
    }
}
