<?php

namespace ss\controllers\record;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\application\exceptions\BadRequestException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\record\RecordCloneModel;
use ss\models\blocks\record\RecordModel;

/**
 * Gets block
 */
class GetCloneBlockController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     *
     * @throws BadRequestException
     */
    public function run()
    {
        $this->checkData(
            [
                'recordBlockId' => [self::NOT_EMPTY],
            ]
        );
        $recordBlockId = (int)$this->get('recordBlockId');

        $blockModel = new BlockModel();
        $recordBlockBlock = BlockModel::model()->getById(
            $recordBlockId
        );
        $recordCloneModel = new RecordCloneModel();

        $blockId = (int)$this->get('id');

        if ($blockId > 0) {
            $blockModel = BlockModel::model()->getById($blockId);
            $recordCloneModel = $blockModel->getContentModel(
                RecordCloneModel::CLASS_NAME
            );
        }

        $this->_checkAccess($recordBlockId, $blockId);

        $recordModel = $recordBlockBlock->getContentModel(
            RecordModel::CLASS_NAME
        );

        if ($recordCloneModel->getId() > 0
            && $recordCloneModel->get('recordId') !== $recordModel->getId()
        ) {
            throw new BadRequestException(
                'Incorrect record ID {recordId} for Record Clone ID {cloneId}',
                [
                    'recordId' => $recordModel->getId(),
                    'cloneId'  => $recordCloneModel->getId(),
                ]
            );
        }

        return $this->_getResponse(
            $blockModel,
            $recordCloneModel,
            $recordModel->get('hasCover')
        );
    }

    /**
     * Gets response
     *
     * @param BlockModel       $blockModel       Clone Block Model
     * @param RecordCloneModel $recordCloneModel Clone Model
     * @param boolean          $hasCover         Has cover
     *
     * @return array
     */
    private function _getResponse(
        $blockModel,
        $recordCloneModel,
        $hasCover
    ) {
        $language = App::getInstance()->getLanguage();

        $titleKey = 'editCloneBlockTitle';
        $descriptionKey = 'editCloneBlockDescription';
        $buttonLabelKey = 'update';
        if ($blockModel->getId() === 0) {
            $titleKey = 'addCloneBlockTitle';
            $descriptionKey = 'addCloneBlockDescription';
            $buttonLabelKey = 'add';
        }

        $forms = [
            'name'               => [
                'name'       => 'name',
                'label'      => $language->getMessage('common', 'name'),
                'validation'
                    => $blockModel->getValidationRulesForField('name'),
                'value'      => $blockModel->get('name'),
            ],
            'hasDescription'     => [
                'name'  => 'hasDescription',
                'label'
                    => $language->getMessage('record', 'hasDescription'),
                'value' => $recordCloneModel->get('hasDescription'),
            ],
            'dateType'  => [
                'label'
                    => $language->getMessage('record', 'dateType'),
                'value' => $recordCloneModel->get('dateType'),
                'name'  => 'dateType',
                'list'  => $recordCloneModel->getDateTypeList()
            ],
            'maxCount' => [
                'name'  => 'maxCount',
                'label' => $language->getMessage('record', 'maxCount'),
                'value' => $recordCloneModel->get('maxCount'),
            ],
            'button'             => [
                'label' => $language->getMessage('common', $buttonLabelKey),
            ]
        ];

        if ($hasCover === true) {
            $forms['hasCover'] = [
                'name'  => 'hasCover',
                'label' => $language->getMessage('record', 'hasCover'),
                'value' => $recordCloneModel->get('hasCover'),
            ];
            $forms['hasCoverZoom'] = [
                'name'  => 'hasCoverZoom',
                'label' => $language->getMessage('record', 'hasCoverZoom'),
                'value' => $recordCloneModel->get('hasCoverZoom'),
            ];
        }

        return [
            'id'          => $blockModel->getId(),
            'title'       => $language->getMessage('record', $titleKey),
            'description' => $language->getMessage('record', $descriptionKey),
            'forms'       => $forms
        ];
    }

    /**
     * Checks access
     *
     * @param int $recordBlockId Record Block ID
     * @param int $blockId       Clone Block ID
     *
     * @return GetCloneBlockController
     */
    private function _checkAccess($recordBlockId, $blockId)
    {
        if ($blockId > 0) {
            $this->checkBlockOperation(
                BlockModel::TYPE_RECORD,
                $recordBlockId,
                Operation::RECORD_UPDATE_CLONE_SETTINGS
            );

            return $this;
        }

        $this->checkBlockOperation(
            BlockModel::TYPE_RECORD,
            Operation::ALL,
            Operation::RECORD_ADD_CLONE
        );

        return $this;
    }
}
