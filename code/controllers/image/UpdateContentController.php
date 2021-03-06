<?php

namespace ss\controllers\image;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\application\exceptions\BadRequestException;
use ss\controllers\_abstract\AbstractController;
use ss\models\_abstract\AbstractModel;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\image\ImageGroupModel;
use ss\models\blocks\image\ImageInstanceModel;
use ss\models\blocks\image\ImageModel;
use ss\models\user\UserEventModel;

/**
 * Updates block's content
 */
class UpdateContentController extends AbstractController
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
                'blockId' => [self::TYPE_INT, self::NOT_EMPTY],
                'groupId' => [self::TYPE_INT],
                'list'    => [self::TYPE_ARRAY]
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_IMAGE,
            $this->get('blockId'),
            Operation::IMAGE_UPDATE_CONTENT
        );

        $blockModel = BlockModel::model()->getById($this->get('blockId'));
        $imageModel = $blockModel->getContentModel(
            ImageModel::CLASS_NAME
        );

        $models = $this->_getModels($imageModel);

        $modelList = [];
        foreach ($models as $model) {
            $modelList[$model->getId()] = $model;
        }

        $list = $this->get('list');
        $sort = 10;
        foreach ($list as $item) {
            $model = $this->_getModel($modelList, $item);
            $model
                ->set(['sort' => $sort])
                ->save();

            $sort += 10;
        }

        $key = 'imagesSorted';
        if ($this->get('groupId') > 0) {
            $key = 'albumsSorted';
        }

        App::getInstance()->getUser()->writeEvent(
            UserEventModel::CATEGORY_BLOCK_IMAGE,
            UserEventModel::TYPE_EDIT,
            sprintf(
                App::getInstance()->getLanguage()->getMessage(
                    'event',
                    $key
                ),
                $blockModel->get('name')
            )
        );

        return $this->getSimpleSuccessResult();
    }

    /**
     * Gets model
     *
     * @param array  $modelList Model list
     * @param string $item      Item key
     *
     * @return AbstractModel
     *
     * @throws BadRequestException
     */
    private function _getModel($modelList, $item)
    {
        if (array_key_exists($item, $modelList) === false) {
            throw new BadRequestException(
                'Unable to find model with ID: {id}',
                [
                    'id' => $item,
                ]
            );
        }

        return $modelList[$item];
    }

    /**
     * Gets models
     *
     * @param ImageModel|AbstractModel $imageModel Image model
     *
     * @return ImageGroupModel[]|ImageInstanceModel[]
     */
    private function _getModels($imageModel)
    {
        if ($imageModel->get('useAlbums') === false) {
            return ImageInstanceModel::model()
                ->byImageId($imageModel->getId())
                ->findAll();
        }

        $groupId = $this->get('groupId');

        if ($groupId === 0) {
            return ImageGroupModel::model()
                ->byImageId($imageModel->getId())
                ->findAll();
        }

        return ImageInstanceModel::model()
            ->byGroupId($groupId)
            ->findAll();
    }
}
