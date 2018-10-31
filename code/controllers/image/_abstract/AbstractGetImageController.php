<?php

namespace ss\controllers\image\_abstract;

use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\image\ImageInstanceModel;
use ss\models\blocks\image\ImageModel;

/**
 * Abstract class to get image details
 */
abstract class AbstractGetImageController extends AbstractController
{

    /**
     * Gets crop data
     *
     * @param int $instanceId Instance ID
     *
     * @return array
     *
     * @throws NotFoundException
     */
    public function getImage($instanceId)
    {
        $imageModel = ImageModel::model()->findByImageInstanceId($instanceId);

        $imageInstanceModel = ImageInstanceModel::model()
            ->byId($instanceId)
            ->find();
        if ($imageInstanceModel instanceof ImageInstanceModel === false) {
            throw new NotFoundException(
                'Unable to find ImageInstanceModel by ID: {id}',
                [
                    'id' => $instanceId
                ]
            );
        }

        $isCover = null;
        if ($imageModel->get('useAlbums') === true) {
            $isCover = $imageInstanceModel->get('isCover');
        }

        return [
            'isCover' => $isCover,
            'alt'     => $imageInstanceModel->get('alt'),
            'link'    => $imageInstanceModel->get('link'),
        ];
    }
}
