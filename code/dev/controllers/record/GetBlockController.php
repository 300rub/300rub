<?php

namespace ss\controllers\record;

use ss\application\App;
use ss\application\components\helpers\DateTime;
use ss\application\components\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\record\RecordModel;

/**
 * Gets block
 */
class GetBlockController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $language = App::getInstance()->getLanguage();
        $blockModel = new BlockModel();
        $recordModel = new RecordModel();

        $blockId = (int)$this->get('id');

        $this->_checkAccess($blockId);

        if ($blockId > 0) {
            $blockModel = BlockModel::model()->getById($blockId);
            $recordModel = $blockModel->getContentModel(
                RecordModel::CLASS_NAME
            );
        }

        $titleKey = 'editBlockTitle';
        $descriptionKey = 'editBlockDescription';
        $buttonLabelKey = 'update';
        if ($blockId === 0) {
            $titleKey = 'addBlockTitle';
            $descriptionKey = 'addBlockDescription';
            $buttonLabelKey = 'add';
        }

        $dateTime = new DateTime();

        return [
            'id'          => $blockId,
            'title'       => $language->getMessage('record', $titleKey),
            'description' => $language->getMessage('record', $descriptionKey),
            'forms'       => [
                'name'               => [
                    'name'       => 'name',
                    'label'      => $language->getMessage('common', 'name'),
                    'validation'
                        => $blockModel->getValidationRulesForField('name'),
                    'value'      => $blockModel->get('name'),
                ],
                'hasCover'           => [
                    'name'  => 'hasCover',
                    'label' => $language->getMessage('record', 'hasCover'),
                    'value' => $recordModel->get('hasCover'),
                ],
                'hasImages'          => [
                    'name'  => 'hasImages',
                    'label' => $language->getMessage('record', 'hasImages'),
                    'value' => $recordModel->get('hasImages'),
                ],
                'hasCoverZoom'       => [
                    'name'  => 'hasCoverZoom',
                    'label' => $language->getMessage('record', 'hasCoverZoom'),
                    'value' => $recordModel->get('hasCoverZoom'),
                ],
                'hasDescription'     => [
                    'name'  => 'hasDescription',
                    'label'
                        => $language->getMessage('record', 'hasDescription'),
                    'value' => $recordModel->get('hasDescription'),
                ],
                'useAutoload'        => [
                    'name'  => 'useAutoload',
                    'label' => $language->getMessage('record', 'useAutoload'),
                    'value' => $recordModel->get('useAutoload'),
                ],
                'pageNavigationSize' => [
                    'name'  => 'pageNavigationSize',
                    'label' => $language->getMessage(
                        'record',
                        'pageNavigationSize'
                    ),
                    'value' => $recordModel->get('pageNavigationSize'),
                ],
                'shortCardDateType'  => [
                    'label'
                        => $language->getMessage('record', 'shortCardDateType'),
                    'value' => $recordModel->get('shortCardDateType'),
                    'name'  => 'shortCardDateType',
                    'list'  => $dateTime->getFormatList()
                ],
                'fullCardDateType'   => [
                    'label'
                        => $language->getMessage('record', 'fullCardDateType'),
                    'value' => $recordModel->get('fullCardDateType'),
                    'name'  => 'fullCardDateType',
                    'list'  => $dateTime->getFormatList()
                ],
                'button'             => [
                    'label' => $language->getMessage('common', $buttonLabelKey),
                ]
            ]
        ];
    }

    /**
     * Checks access
     *
     * @param int $blockId Block ID
     *
     * @return GetBlockController
     */
    private function _checkAccess($blockId)
    {
        if ($blockId > 0) {
            $this->checkBlockOperation(
                BlockModel::TYPE_RECORD,
                $blockId,
                Operation::RECORD_UPDATE_SETTINGS
            );

            return $this;
        }

        $this->checkBlockOperation(
            BlockModel::TYPE_RECORD,
            Operation::ALL,
            Operation::RECORD_ADD
        );

        return $this;
    }
}
