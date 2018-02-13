<?php

namespace ss\controllers\record;

use ss\application\App;
use ss\application\components\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\record\RecordModel;

/**
 * Adds block
 */
class CreateBlockController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->checkBlockOperation(
            BlockModel::TYPE_IMAGE,
            Operation::ALL,
            Operation::IMAGE_ADD
        );

        $this->checkData(
            [
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

        $recordModel = new RecordModel();
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

        $blockModel = new BlockModel();
        $blockModel->set(
            [
                'name'        => $this->get('name'),
                'language'    => App::web()->getLanguage()->getActiveId(),
                'contentType' => BlockModel::TYPE_RECORD,
                'contentId'   => $recordModel->getId(),
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
