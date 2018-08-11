<?php

namespace ss\models\help;

use ss\application\App;
use ss\models\help\_base\AbstractCategoryModel;

/**
 * Model for working with table "category" (help DB)
 */
class CategoryModel extends AbstractCategoryModel
{

    /**
     * Gets CategoryModel
     *
     * @return CategoryModel
     */
    public static function model()
    {
        return new self;
    }

    /**
     * Sets content
     *
     * @return CategoryModel
     */
    public function setContent()
    {
        $this->setPdo();

        $model = LanguageCategoryModel::model()
            ->byAlias($this->getAlias())
            ->find();

        $this
            ->setTitle($model->get('title'))
            ->setKeywords($model->get('keywords'))
            ->setDescription($model->get('description'));

        return $this;
    }
}
