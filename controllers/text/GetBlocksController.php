<?php

namespace testS\controllers\text;

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
            'list'        => $list,
            'back'        => [
                'controller' => 'block',
                'action'     => 'blocks'
            ],
            'settings'    => [
                'controller' => 'text',
                'action'     => 'block'
            ],
            'design'      => [
                'controller' => 'text',
                'action'     => 'design'
            ],
            'content'     => [
                'controller' => 'text',
                'action'     => 'content'
            ],
            'canAdd'      => $canAdd,
        ];
    }
}
