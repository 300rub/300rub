<?php

namespace ss\controllers\image\_abstract;

use ss\application\App;
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

        $language = App::getInstance()->getLanguage();

        return [
            'id'      => $instanceId,
            'blockId' => $this->get('blockId'),
            'forms'     => [
                'alt'      => [
                    'name'       => 'alt',
                    'label'      => $language->getMessage('image', 'alt'),
                    'value'      => $imageInstanceModel->get('alt'),
                    'validation' => $imageInstanceModel
                        ->getValidationRulesForField('alt'),
                ],
                'link'      => [
                    'name'       => 'link',
                    'label'      => $language->getMessage('common', 'link'),
                    'value'      => $imageInstanceModel->get('link'),
                    'validation' => $imageInstanceModel
                        ->getValidationRulesForField('link'),
                ],
                'isCover'      => [
                    'name'  => 'isCover',
                    'label' => $language->getMessage('image', 'cover'),
                    'value' => $imageInstanceModel->get('isCover'),
                ],
            ],
            'labels'  => [
                'button' => $language->getMessage('common', 'save')
            ]
        ];
    }
}
