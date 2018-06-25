<?php

namespace ss\models\blocks\menu;

use ss\models\blocks\menu\_content\AbstractContentMenuModel;

/**
 * Model for working with table "menu"
 */
class MenuModel extends AbstractContentMenuModel
{

    /**
     * Class name
     */
    const CLASS_NAME = '\\ss\\models\\blocks\\menu\\MenuModel';

    /**
     * Gets MenuModel
     *
     * @return MenuModel
     */
    public static function model()
    {
        return new self;
    }
}
