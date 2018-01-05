<?php

namespace testS\controllers\_abstract;

use testS\application\App;

/**
 * Abstract class for working with controllers
 */
abstract class AbstractController extends AbstractOperationController
{

    /**
     * Display blocks from section variable name
     */
    const DISPLAY_BLOCKS_FROM_SECTION = 'displayBlocksFromSection';

    /**
     * Form types
     */
    const FORM_TYPE_TEXT = 'text';
    const FORM_TYPE_PASSWORD = 'password';
    const FORM_TYPE_CHECKBOX = 'checkbox';
    const FORM_TYPE_BUTTON = 'button';
    const FORM_TYPE_SELECT = 'select';

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
    protected function getDisplayBlocksFromSection()
    {
        $globalObject = App::web()->getSuperGlobalVariable();

        if ($this->get(self::DISPLAY_BLOCKS_FROM_SECTION) !== null) {
            $value = (int)$this->get(self::DISPLAY_BLOCKS_FROM_SECTION);
            $globalObject->setSessionValue(
                self::DISPLAY_BLOCKS_FROM_SECTION,
                $value
            );
            $globalObject->setCookieValue(
                self::DISPLAY_BLOCKS_FROM_SECTION,
                $value,
                (time() + 86400 * 365 * 10)
            );

            return $value;
        }

        $sessionValue = $globalObject->getSessionValue(
            self::DISPLAY_BLOCKS_FROM_SECTION
        );
        if ($sessionValue !== null) {
            $value = (int)$sessionValue;
            $cookieValue = $globalObject->getCookieValue(
                self::DISPLAY_BLOCKS_FROM_SECTION
            );
            if ($cookieValue === null) {
                $globalObject->setCookieValue(
                    self::DISPLAY_BLOCKS_FROM_SECTION,
                    $value,
                    (time() + 86400 * 365 * 10)
                );
            }

            return $value;
        }

        $cookieValue = $globalObject->getCookieValue(
            self::DISPLAY_BLOCKS_FROM_SECTION
        );
        if ($cookieValue !== null) {
            $value = (int)$cookieValue;
            $globalObject->setSessionValue(
                self::DISPLAY_BLOCKS_FROM_SECTION,
                $value
            );
            return $value;
        }

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
