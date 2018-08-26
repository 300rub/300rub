<?php

namespace ss\models\user;

use ss\application\App;
use ss\models\user\_base\AbstractUserEventModel;

/**
 * Model for working with table "userEvents"
 */
class UserEventModel extends AbstractUserEventModel
{

    /**
     * Gets UserEventModel
     *
     * @return UserEventModel
     */
    public static function model()
    {
        return new self;
    }

    /**
     * Gets category value
     *
     * @return string
     */
    public function getCategoryValue()
    {
        $categoryList = $this->getCategoryList();
        $category = $this->get('category');

        if (array_key_exists($category, $categoryList) === false) {
            return App::getInstance()
                ->getLanguage()
                ->getMessage('common', 'unknown');
        }

        return $categoryList[$category];
    }

    /**
     * Gets type value
     *
     * @return string
     */
    public function getTypeValue()
    {
        $typeList = $this->getTypeList();
        $type = $this->get('type');

        if (array_key_exists($type, $typeList) === false) {
            return App::getInstance()
                ->getLanguage()
                ->getMessage('common', 'unknown');
        }

        return $typeList[$type];
    }
}
