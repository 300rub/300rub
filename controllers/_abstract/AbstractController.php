<?php

namespace ss\controllers\_abstract;

use ss\application\App;

/**
 * Abstract class for working with controllers
 */
abstract class AbstractController extends AbstractOperationController
{

    /**
     * Block section variable name
     */
    const BLOCK_SECTION = 'blockSection';

    /**
     * Form types
     */
    const FORM_TYPE_TEXT = 'text';
    const FORM_TYPE_PASSWORD = 'password';
    const FORM_TYPE_CHECKBOX = 'checkbox';
    const FORM_TYPE_BUTTON = 'button';
    const FORM_TYPE_SELECT = 'select';

    /**
     * Block section
     *
     * @var integer
     */
    private $_blockSection = null;

    /**
     * Runs controller
     *
     * @return array
     */
    abstract public function run();

    /**
     * Gets simple success result
     *
     * @return array
     */
    protected function getSimpleSuccessResult()
    {
        return [
            'result' => true
        ];
    }

    /**
     * Gets displayBlocksFromPage
     *
     * @return int
     */
    protected function getBlockSection()
    {
        if ($this->_blockSection !== null) {
            return $this->_blockSection;
        }

        $globalObject = App::web()->getSuperGlobalVariable();

        if ($this->get(self::BLOCK_SECTION) !== null) {
            $value = (int)$this->get(self::BLOCK_SECTION);
            $globalObject->setSessionValue(
                self::BLOCK_SECTION,
                $value
            );
            $globalObject->setCookieValue(
                self::BLOCK_SECTION,
                $value,
                (time() + 86400 * 365 * 10)
            );

            $this->_blockSection = $value;
            return $value;
        }

        $sessionValue = $globalObject->getSessionValue(
            self::BLOCK_SECTION
        );
        if ($sessionValue !== null) {
            $value = (int)$sessionValue;
            $cookieValue = $globalObject->getCookieValue(
                self::BLOCK_SECTION
            );
            if ($cookieValue === null) {
                $globalObject->setCookieValue(
                    self::BLOCK_SECTION,
                    $value,
                    (time() + 86400 * 365 * 10)
                );
            }

            $this->_blockSection = $value;
            return $value;
        }

        $cookieValue = $globalObject->getCookieValue(
            self::BLOCK_SECTION
        );
        if ($cookieValue !== null) {
            $value = (int)$cookieValue;
            $globalObject->setSessionValue(
                self::BLOCK_SECTION,
                $value
            );

            $this->_blockSection = $value;
            return $value;
        }

        $this->_blockSection = 0;
        return 0;
    }

    /**
     * Gets content from view
     *
     * @param string $viewFile View file
     * @param array  $data     Data
     *
     * @return string
     */
    protected function getContentFromTemplate($viewFile, $data = [])
    {
        return App::web()->getView()->get($viewFile, $data);
    }

    /**
     * Removes saved data
     *
     * @return void
     */
    protected function removeSavedData()
    {
        $bdObject = App::web()->getDb();
        $bdObject->rollbackTransaction();
        $bdObject->startTransaction();
    }
}
