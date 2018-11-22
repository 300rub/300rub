<?php

namespace ss\application\components\common;

use ss\application\exceptions\CommonException;
use ss\models\blocks\_abstract\AbstractDesignModel;

/**
 * Class for working with views
 */
class View
{

    /**
     * Twig
     *
     * @var \Twig_Environment
     */
    private $_twig = null;

    /**
     * Gets twig
     *
     * @return \Twig_Environment
     */
    private function _getTwig()
    {
        if ($this->_twig === null) {
            $loader = new \Twig_Loader_Filesystem(
                $this->_getViewsRootDir()
            );

            $this->_twig = new \Twig_Environment($loader);

            if (APP_ENV === ENV_DEV) {
                $this->_twig->enableDebug();
                $this->_twig->addExtension(new \Twig_Extension_Debug());
            }
        }

        return $this->_twig;
    }

    /**
     * Gets content from view
     *
     * @param string $viewFile View file
     * @param array  $data     Data
     *
     * @return string
     */
    public function get($viewFile, $data = [])
    {
        return $this->_getTwig()->render(
            sprintf('%s.twig', $viewFile),
            $data
        );
    }

    /**
     * Gets path to views root dir
     *
     * @return string
     */
    private function _getViewsRootDir()
    {
        return CODE_ROOT . '/views/';
    }

    /**
     * Generates CSS ID
     *
     * @param string $selector CSS selector
     * @param string $type     Type
     *
     * @return string
     */
    public function generateCssContainerId($selector, $type)
    {
        return sprintf(
            '%s-%s',
            str_replace(['.', ' ', '/'], ['', '-', '-'], $selector),
            $type
        );
    }

    /**
     * Generates JS ID
     *
     * @param string $selector Selector
     *
     * @return string
     */
    public function generateJsId($selector)
    {
        return str_replace(['.', ' ', '/'], ['', '-', '-'], $selector);
    }

    /**
     * Generates CSS
     *
     * @param AbstractDesignModel $model    Model
     * @param string              $selector CSS selector
     *
     * @throws CommonException
     *
     * @return array
     */
    public function generateCss(AbstractDesignModel $model, $selector)
    {
        $cssContainerId
            = $this->generateCssContainerId($selector, $model->getCssType());

        return [
            $cssContainerId => $model->generateCss($selector)
        ];
    }

    /**
     * Generates JS
     *
     * @param string $path      File path
     * @param int    $container CSS container
     * @param array  $data      View data
     *
     * @return array
     */
    public function generateJs($path, $container, array $data = [])
    {
        $jsId = $this->generateJsId($container);
        $data['container'] = $container;

        return [
            $jsId => $this->get($path, $data)
        ];
    }
}
