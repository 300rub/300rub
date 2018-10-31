<?php

namespace ss\controllers\record;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\record\RecordCloneModel;

/**
 * Gets a list of blocks
 */
class GetBlocksController extends AbstractController
{

    /**
     * Packed clone models by content ID
     *
     * @var array
     */
    private $_packedCloneModels = [];

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->checkUser();

        $language = App::getInstance()->getLanguage();

        $blockModels = $this->_getBlockModels();

        $this->_setPackedCloneModels();

        $list = [];
        foreach ($blockModels as $blockModel) {
            $canUpdateSettings = $this->hasBlockOperation(
                BlockModel::TYPE_RECORD,
                $blockModel->getId(),
                Operation::RECORD_UPDATE_SETTINGS
            );
            $canUpdateDesign = $this->hasBlockOperation(
                BlockModel::TYPE_RECORD,
                $blockModel->getId(),
                Operation::RECORD_UPDATE_DESIGN
            );
            $canUpdateContent = $this->hasBlockOperation(
                BlockModel::TYPE_RECORD,
                $blockModel->getId(),
                Operation::RECORD_UPDATE_CONTENT
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
                'canUpdateContent'  => $canUpdateContent,
                'clones'            => $this->_getClones(
                    $blockModel,
                    $canUpdateSettings,
                    $canUpdateDesign
                )
            ];
        }

        $canAdd = $this->hasBlockOperation(
            BlockModel::TYPE_RECORD,
            Operation::ALL,
            Operation::RECORD_ADD
        );

        return [
            'title'
                => $language->getMessage('record', 'records'),
            'description'
                => $language->getMessage('record', 'panelDescription'),
            'list'        => $list,
            'back'        => [
                'controller' => 'block',
                'action'     => 'blocks'
            ],
            'settings'    => [
                'controller' => 'record',
                'action'     => 'block'
            ],
            'design'      => [
                'controller' => 'record',
                'action'     => 'design'
            ],
            'content'     => [
                'controller' => 'record',
                'action'     => 'content'
            ],
            'canAdd'      => $canAdd,
        ];
    }

    /**
     * Sets packed clone models
     *
     * @return void
     */
    private function _setPackedCloneModels()
    {
        $cloneBlockModels = $this->_getCloneBlockModels();

        $this->_packedCloneModels = [];
        foreach ($cloneBlockModels as $cloneBlockModel) {
            $contentModel = $cloneBlockModel->getContentModel(
                RecordCloneModel::CLASS_NAME
            );

            $recordId = $contentModel->get('recordId');
            $hasRecordId = array_key_exists(
                $recordId,
                $this->_packedCloneModels
            );
            if ($hasRecordId === false) {
                $this->_packedCloneModels[$recordId] = [];
            }

            $this->_packedCloneModels[$recordId][] = $cloneBlockModel;
        }
    }

    /**
     * Gets block models
     *
     * @return BlockModel[]
     */
    private function _getBlockModels()
    {
        return BlockModel::model()
            ->byContentType(BlockModel::TYPE_RECORD)
            ->byLanguage(App::getInstance()->getLanguage()->getActiveId())
            ->bySectionId($this->getBlockSection())
            ->findAll();
    }

    /**
     * Gets clone block models
     *
     * @return BlockModel[]
     */
    private function _getCloneBlockModels()
    {
        return BlockModel::model()
            ->byContentType(BlockModel::TYPE_RECORD_CLONE)
            ->byLanguage(App::getInstance()->getLanguage()->getActiveId())
            ->bySectionId($this->getBlockSection())
            ->findAll();
    }

    /**
     * Gets clones
     *
     * @param BlockModel $blockModel        Block model
     * @param bool       $canUpdateSettings Update settings flag
     * @param bool       $canUpdateDesign   Update design flag
     *
     * @return array
     */
    private function _getClones(
        $blockModel,
        $canUpdateSettings,
        $canUpdateDesign
    ) {
        $clones = [];

        if ($canUpdateSettings === true
            || $canUpdateDesign === true
        ) {
            $cloneModels = $this->_getCloneModelsByContentId(
                $blockModel->get('contentId')
            );

            foreach ($cloneModels as $cloneModel) {
                $clones[] = [
                    'name'              => $cloneModel->get('name'),
                    'id'                => $cloneModel->getId(),
                    'canUpdateSettings' => $canUpdateSettings,
                    'canUpdateDesign'   => $canUpdateDesign,
                ];
            }
        }

        return $clones;
    }

    /**
     * Gets clone block models by content ID
     *
     * @param int $contentId Content ID
     *
     * @return BlockModel[]
     */
    private function _getCloneModelsByContentId($contentId)
    {
        $hasKey = array_key_exists($contentId, $this->_packedCloneModels);
        if ($hasKey === true) {
            return $this->_packedCloneModels[$contentId];
        }

        return [];
    }
}
