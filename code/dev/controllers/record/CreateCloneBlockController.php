<?php

namespace ss\controllers\record;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\application\exceptions\BadRequestException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\record\RecordCloneModel;

/**
 * Creates clone block
 */
class CreateCloneBlockController extends AbstractController
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
        $this->checkBlockOperation(
            BlockModel::TYPE_RECORD,
            Operation::ALL,
            Operation::RECORD_ADD_CLONE
        );

        $this->checkData(
            [
                'recordBlockId'  => [self::TYPE_INT, self::NOT_EMPTY],
                'name'           => [self::TYPE_STRING],
                'hasCover'       => [self::TYPE_BOOL],
                'hasCoverZoom'   => [self::TYPE_BOOL],
                'hasDescription' => [self::TYPE_BOOL],
                'dateType'       => [self::TYPE_INT],
                'maxCount'       => [self::TYPE_INT],
            ]
        );

        $recordBlock = BlockModel::model()->getById(
            $this->get('recordBlockId')
        );
        if ($recordBlock->get('contentType') !== BlockModel::TYPE_RECORD) {
            throw new BadRequestException(
                'Incorrect type recordBlockId: {recordBlockId}. Type: {type}',
                [
                    'recordBlockId' => $this->get('recordBlockId'),
                    'type'          => $recordBlock->get('contentType'),
                ]
            );
        }

        $recordCloneModel = new RecordCloneModel();
        $recordCloneModel->set(
            [
                'recordId'       => $recordBlock->get('contentId'),
                'hasCover'       => $this->get('hasCover'),
                'hasCoverZoom'   => $this->get('hasCoverZoom'),
                'hasDescription' => $this->get('hasDescription'),
                'dateType'       => $this->get('dateType'),
                'maxCount'       => $this->get('maxCount'),
            ]
        );
        $recordCloneModel->save();

        $blockModel = new BlockModel();
        $blockModel->set(
            [
                'name'        => $this->get('name'),
                'language'    => App::getInstance()->getLanguage()->getActiveId(),
                'contentType' => BlockModel::TYPE_RECORD_CLONE,
                'contentId'   => $recordCloneModel->getId(),
            ]
        );
        $blockModel->save();
        $errors = $blockModel->getParsedErrors();
        if (count($errors) > 0) {
            $this->removeSavedData();

            return [
                'errors' => $errors
            ];
        }

        return $this->getSimpleSuccessResult();
    }
}
