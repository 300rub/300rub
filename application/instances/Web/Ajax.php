<?php

namespace testS\application\instances\Web;

use testS\application\components\User;
use testS\application\instances\_abstract\AbstractWeb;
use testS\application\instances\Web;
use testS\models\UserModel;
use testS\models\UserSessionModel;

/**
 * Class for working with AJAX requests
 */
class Ajax extends Web
{

    /**
     * Flag of using transaction
     *
     * @var boolean
     */
    private $_useTransaction = false;

    public function getOutput()
    {
        try {
            $this->_setUseTransaction();
        } catch (\Exception $e) {

        }
    }

    private function _setUseTransaction()
    {
        $method = strtoupper(
            $this
                ->getSuperGlobalVariable()
                ->getServerValue('REQUEST_METHOD')
        );

        $this->useTransaction = $method !== self::METHOD_GET;

        return $this;
    }

    private function _setPrefix()
    {

    }
}
