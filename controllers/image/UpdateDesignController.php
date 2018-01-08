<?php

namespace testS\controllers\image;

use testS\application\components\Operation;
use testS\application\exceptions\BadRequestException;
use testS\controllers\_abstract\AbstractController;
use testS\models\_abstract\AbstractModel;
use testS\models\blocks\block\BlockModel;
use testS\models\blocks\image\ImageModel;

/**
 * Updates block's design
 */
class UpdateDesignController extends AbstractController
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
                'id' => [self::TYPE_INT, self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_IMAGE,
            $this->get('id'),
            Operation::IMAGE_UPDATE_DESIGN
        );

        $blockModel = BlockModel::model()->getById($this->get('id'));

        $imageModel = $blockModel->getContentModel(
            false,
            null,
            ImageModel::CLASS_NAME
        );

        $imageModel = $this->_setImageDesign($imageModel);
        $imageModel->save();

        return $this->getSimpleSuccessResult();
    }

    /**
     * Sets image model
     *
     * @param ImageModel|AbstractModel $imageModel Image model
     *
     * @return ImageModel
     *
     * @throws BadRequestException
     */
    private function _setImageDesign($imageModel)
    {
        $imageModel->set(
            [
                'designBlockModel'
                => $this->get('designBlockModel'),
            ]
        );

        if (empty($this->get('designImageZoomModel')) === false) {
            $imageModel->set(
                [
                    'designImageZoomModel'
                    => $this->get('designImageZoomModel'),
                ]
            );

            return $imageModel;
        }

        if (empty($this->get('designImageSliderModel')) === false) {
            $imageModel->set(
                [
                    'designImageSliderModel'
                    => $this->get('designImageSliderModel'),
                ]
            );

            return $imageModel;
        }

        if (empty($this->get('designImageSimpleModel')) === false) {
            $imageModel->set(
                [
                    'designImageSimpleModel'
                    => $this->get('designImageSimpleModel'),
                ]
            );

            return $imageModel;
        }

        throw new BadRequestException(
            'Unable to find find designImageZoomModel or ' .
            'designImageSliderModel or designImageSimpleModel ' .
            'in request to update design'
        );
    }
}
