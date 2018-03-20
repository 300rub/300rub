<?php

namespace ss\application\components;

use ss\application\exceptions\CommonException;
use ss\models\_abstract\AbstractModel;

/**
 * Class for working with views
 */
class View
{

    /**
     * Map
     *
     * @var array
     */
    private $_map = [
        '\\ss\\models\\blocks\\block\\DesignBlockModel' => 'block',
        '\\ss\\models\\blocks\\text\\DesignTextModel'   => 'text',
    ];

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
        $path = $this->_getViewsRootDir() . $viewFile . '.php';

        extract($data, EXTR_OVERWRITE);

        ob_start();
        ob_implicit_flush(false);
        include $path;
        return ob_get_clean();
    }

    /**
     * Gets path to views root dir
     *
     * @return string
     */
    private function _getViewsRootDir()
    {
        return __DIR__ . '/../../views/';
    }

    /**
     * Generates CSS ID
     *
     * @param string $selector CSS selector
     * @param string $type     Type
     *
     * @return string
     */
    public function generateCssId($selector, $type)
    {
        return sprintf(
            '%s-%s',
            str_replace(['.', ' ', '/'], ['', '-', '-'], $selector),
            $type
        );
    }

    /**
     * Generates CSS
     *
     * @param AbstractModel $model    Model
     * @param string        $selector CSS selector
     *
     * @throws CommonException
     *
     * @return array
     */
    public function generateCss(AbstractModel $model, $selector)
    {
        $type = null;
        foreach ($this->_map as $instance => $path) {
            if ($model instanceof $instance) {
                $type = $path;
            }
        }

        if ($type === null) {
            throw new CommonException(
                'Unable to detect design type to get CSS. Model given: {class}',
                [
                    'class' => get_class($model)
                ]
            );
        }

        $cssId = $this->generateCssId($selector, $type);

        $css = $this->get(
            'design/' . $type,
            [
                'model'    => $model,
                'id'       => $cssId,
                'selector' => $selector,
            ]
        );

        return [
            $cssId => $css
        ];
    }
}
