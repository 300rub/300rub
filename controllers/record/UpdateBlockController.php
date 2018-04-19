<?php

namespace ss\controllers\record;

use ss\application\components\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\record\RecordModel;

/**
 * Updates block
 */
class UpdateBlockController extends AbstractController
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
                'id'                 => [self::TYPE_INT, self::NOT_EMPTY],
                'name'               => [self::TYPE_STRING],
                'hasCover'           => [self::TYPE_BOOL],
                'hasImages'          => [self::TYPE_BOOL],
                'hasCoverZoom'       => [self::TYPE_BOOL],
                'hasDescription'     => [self::TYPE_BOOL],
                'useAutoload'        => [self::TYPE_BOOL],
                'pageNavigationSize' => [self::TYPE_INT],
                'shortCardDateType'  => [self::TYPE_INT],
                'fullCardDateType'   => [self::TYPE_INT],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_RECORD,
            $this->get('id'),
            Operation::RECORD_UPDATE_SETTINGS
        );

        $blockModel = BlockModel::model()->getById($this->get('id'));
        $recordModel = $blockModel->getContentModel(
            RecordModel::CLASS_NAME
        );
        $recordModel->set(
            [
                'hasCover'           => $this->get('hasCover'),
                'hasImages'          => $this->get('hasImages'),
                'hasCoverZoom'       => $this->get('hasCoverZoom'),
                'hasDescription'     => $this->get('hasDescription'),
                'useAutoload'        => $this->get('useAutoload'),
                'pageNavigationSize' => $this->get('pageNavigationSize'),
                'shortCardDateType'  => $this->get('shortCardDateType'),
                'fullCardDateType'   => $this->get('fullCardDateType'),
            ]
        );
        $recordModel->save();

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
