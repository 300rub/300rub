<?php

namespace ss\controllers\image\_abstract;

use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\image\ImageInstanceModel;

/**
 * Abstract class to delete images
 */
abstract class AbstractDeleteImageController extends AbstractController
{

    /**
     * Deletes image
     *
     * @param int $instanceId Instance ID
     *
     * @return array
     *
     * @throws NotFoundException
     */
    protected function delete($instanceId)
    {
        $imageInstanceModel = ImageInstanceModel::model()
            ->byId($instanceId)
            ->withRelations(['originalFileModel'])
            ->find();
        if ($imageInstanceModel instanceof ImageInstanceModel === false) {
            throw new NotFoundException(
                'Unable to find ImageInstanceModel by ID: {id}',
                [
                    'id' => $instanceId
                ]
            );
        }

        $url = $imageInstanceModel->get('originalFileModel')->getUrl();

        $imageInstanceModel->delete();

        return $url;
    }
}
