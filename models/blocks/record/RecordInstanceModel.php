<?php

namespace ss\models\blocks\record;

use ss\application\components\Db;
use ss\models\blocks\image\ImageGroupModel;
use ss\models\blocks\record\_base\AbstractRecordInstanceModel;
use ss\models\blocks\text\TextInstanceModel;

/**
 * Model for working with table "recordInstances"
 */
class RecordInstanceModel extends AbstractRecordInstanceModel
{

    /**
     * Gets new model
     *
     * @return RecordInstanceModel
     */
    public static function model()
    {
        return new self;
    }

    /**
     * Find by URL
     *
     * @param string $url URL
     *
     * @return RecordInstanceModel
     */
    public function byUrl($url)
    {
        $this->getDb()->addJoin(
            'seo',
            'seo',
            Db::DEFAULT_ALIAS,
            'seoId'
        );

        $this->getDb()->addWhere(
            'seo.url = :url'
        );
        $this->getDb()->addParameter('url', $url);

        return $this;
    }

    /**
     * Adds recordId condition to SQL request
     *
     * @param int $recordId Record ID
     *
     * @return RecordInstanceModel
     */
    public function byRecordId($recordId)
    {
        $this->getDb()->addWhere(
            sprintf(
                '%s.recordId = :recordId',
                Db::DEFAULT_ALIAS
            )
        );
        $this->getDb()->addParameter('recordId', (int)$recordId);

        return $this;
    }

    /**
     * Runs before save
     *
     * @return void
     */
    protected function beforeSave()
    {
        $recordId = $this->get('recordId');

        if ($this->getId() === 0
            && $recordId > 0
        ) {
            $recordModel = RecordModel::model()
                ->byId($recordId)
                ->find();

            if ($this->getField('textTextInstanceModel') === null) {
                $textInstance = new TextInstanceModel();
                $textInstance->set(
                    [
                        'textId' => $recordModel->get('textTextId')
                    ]
                );
                $textInstance->save();
                $this->set(
                    [
                        'textTextInstanceId' => $textInstance->getId(),
                    ]
                );
            }

            if ($this->getField('descriptionTextInstanceModel') === null) {
                $descriptionInstance = new TextInstanceModel();
                $descriptionInstance->set(
                    [
                        'textId' => $recordModel->get('descriptionTextId')
                    ]
                );
                $descriptionInstance->save();
                $this->set(
                    [
                        'descriptionTextInstanceId' => $descriptionInstance->getId(),
                    ]
                );
            }

            if ($this->get('imageGroupId') === 0) {
                $imageGroup = new ImageGroupModel();
                $imageGroup->set(
                    [
                        'imageId' => $recordModel->get('imagesImageId'),
                        'seoModel' => [
                            'name' => substr(md5(uniqid() . time()), 0, 10)
                        ]
                    ]
                );
                $imageGroup->save();
                $this->set(
                    [
                        'imageGroupId' => $imageGroup->getId(),
                    ]
                );
            }
        }

        parent::beforeSave();
    }

    public function getName()
    {
        return $this->get('seoModel')->get('name');
    }
}
