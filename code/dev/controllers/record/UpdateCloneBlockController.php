<?php

namespace ss\controllers\record;

use ss\application\components\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\record\RecordCloneModel;

/**
 * Updates clone block
 */
class UpdateCloneBlockController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->checkData(
            [
                'recordBlockId'  => [self::TYPE_INT, self::NOT_EMPTY],
                'id'             => [self::TYPE_INT, self::NOT_EMPTY],
                'name'           => [self::TYPE_STRING],
                'hasCover'       => [self::TYPE_BOOL],
                'hasCoverZoom'   => [self::TYPE_BOOL],
                'hasDescription' => [self::TYPE_BOOL],
                'dateType'       => [self::TYPE_INT],
                'maxCount'       => [self::TYPE_INT],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_RECORD,
            $this->get('recordBlockId'),
            Operation::RECORD_UPDATE_CLONE_SETTINGS
        );

        $blockModel = BlockModel::model()->getById($this->get('id'));
        $recordCloneModel = $blockModel->getContentModel(
            RecordCloneModel::CLASS_NAME
        );
        $recordCloneModel->set(
            [
                'hasCover'       => $this->get('hasCover'),
                'hasCoverZoom'   => $this->get('hasCoverZoom'),
                'hasDescription' => $this->get('hasDescription'),
                'dateType'       => $this->get('dateType'),
                'maxCount'       => $this->get('maxCount'),
            ]
        );
        $recordCloneModel->save();

        $blockModel->set(
            [
                'name' => $this->get('name'),
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

        $blockModel->setContent();

        return [
            'result' => true,
            'html'   => $blockModel->getHtml(),
            'css'    => $blockModel->getCss(),
            'js'     => $blockModel->getJs(),
        ];
    }
}
