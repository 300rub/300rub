<?php

namespace ss\controllers\record;

use ss\application\App;
use ss\application\components\Operation;
use ss\application\exceptions\BadRequestException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\image\ImageModel;
use ss\models\blocks\record\RecordModel;

/**
 * Gets block's design
 */
class GetDesignController extends AbstractController
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

        /*

<div class="record-1">
	<div class="list">
		<div class="item">

		</div>
	</div>
</div>

short
	- view type
		#### Add
	- container
		block
	- item
		block
	- title
		block
		text
	- date
		text
	- description
		text
		block
	- cover
		############# Add
	- pagination container
		block
	- pagination item
		block
		text

full
	- container ########## Add
		block
	- title
		block
		text
	- date
		text
		position #################### Add
	- images
		############## Add

        */

        $this->checkData(
            [
                'id' => [self::NOT_EMPTY],
            ]
        );

        $blockId = (int)$this->get('id');

        $this->checkBlockOperation(
            BlockModel::TYPE_IMAGE,
            $blockId,
            Operation::RECORD_UPDATE_DESIGN
        );

        $recordModel = BlockModel::model()
            ->getById($blockId)
            ->getContentModel(
                null,
                RecordModel::CLASS_NAME
            );

        $data = [
            $recordModel
                ->get('designBlockModel')
                ->getDesign(sprintf('.block-%s', $blockId))
        ];

        $cssSelector = sprintf('.image-%s', $recordModel->getId());
        switch ($imageModel->get('type')) {
            case ImageModel::TYPE_SIMPLE:
                $data = array_merge(
                    $data,
                    $imageModel
                        ->get('designImageSimpleModel')
                        ->getDesign($cssSelector)
                );
                break;
            case ImageModel::TYPE_SLIDER:
                $data = array_merge(
                    $data,
                    $imageModel
                        ->get('designImageSliderModel')
                        ->getDesign($cssSelector)
                );
                break;
            default:
                $data = array_merge(
                    $data,
                    $imageModel
                        ->get(
                            'designImageZoomModel'
                        )->getDesign($cssSelector)
                );
                break;
        }

        $language = App::web()->getLanguage();

        return [
            'id'          => $blockId,
            'controller'  => 'image',
            'action'      => 'design',
            'title'       => $language->getMessage('image', 'designTitle'),
            'description'
                => $language->getMessage('image', 'designDescription'),
            'list'        => [
                [
                    'title' => $language->getMessage('image', 'designTitle'),
                    'data'  => $data
                ]
            ],
            'button'      => [
                'label' => $language->getMessage('common', 'save'),
            ]
        ];
    }
}
