<?php

namespace ss\models\blocks\record;

use ss\application\components\db\Table;
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
     * Find by Alias
     *
     * @param string $alias Alias
     *
     * @return RecordInstanceModel
     */
    public function byAlias($alias)
    {
        $this->getTable()->addJoin(
            Table::JOIN_TYPE_INNER,
            'seo',
            'seo',
            self::PK_FIELD,
            Table::DEFAULT_ALIAS,
            'seoId'
        );

        $this->getTable()->addWhere(
            'seo.alias = :alias'
        );
        $this->getTable()->addParameter('alias', $alias);

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
        $this->getTable()->addWhere(
            sprintf(
                '%s.recordId = :recordId',
                Table::DEFAULT_ALIAS
            )
        );
        $this->getTable()->addParameter('recordId', (int)$recordId);

        return $this;
    }

    /**
     * Sets limit
     *
     * @param int $limit Limit
     * @param int $page  Page
     *
     * @return RecordInstanceModel
     */
    public function limit($limit, $page = 1)
    {
        $page = (int)$page;
        if ($page < 1) {
            $page = 1;
        }

        $this->getTable()->setLimit(
            sprintf('%s, %s', (($page - 1) * $limit), $limit)
        );

        return $this;
    }

    /**
     * Runs before save
     *
     * @return void
     */
    protected function beforeSave()
    {
        if ($this->getId() === 0
            && $this->get('recordId') > 0
        ) {
            $this->_beforeCreate();
        }

        parent::beforeSave();
    }

    /**
     * Runs before creating
     *
     * @return void
     */
    private function _beforeCreate()
    {
        $recordId = $this->get('recordId');

        $recordModel = RecordModel::model()
            ->byId($recordId)
            ->find();

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

        $descriptionInstance = new TextInstanceModel();
        $descriptionInstance->set(
            [
                'textId' => $recordModel->get('descriptionTextId')
            ]
        );
        $descriptionInstance->save();
        $this->set(
            [
                'descriptionTextInstanceId'
                => $descriptionInstance->getId(),
            ]
        );

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

    /**
     * Gets name
     *
     * @return string
     */
    public function getName()
    {
        return $this->get('seoModel')->get('name');
    }
}
