<?php

namespace testS\models;

use testS\components\exceptions\CommonException;
use testS\components\View;

/**
 * Abstract class for working with content models
 *
 * @package testS\models
 */
abstract class AbstractContentModel extends AbstractModel
{

    /**
     * CSS
     *
     * @var array
     */
    private static $_css = [];

    /**
     * Sets CSS
     *
     * @param int $id
     *
     * @return AbstractContentModel
     */
    abstract public function setCss($id = null);

    /**
     * Gets CSS
     *
     * @return array
     */
    public static function getCss()
    {
        return self::$_css;
    }

    /**
     * Adds CSS to collection
     *
     * @param AbstractModel $model
     * @param string        $selector
     *
     * @throws CommonException
     *
     * @return AbstractContentModel
     */
    protected function addCss(AbstractModel $model, $selector)
    {
        $type = null;
        if ($model instanceof DesignBlockModel) {
            $type = "block";
        } elseif ($model instanceof DesignTextModel) {
            $type = "text";
        }

        if ($type === null) {
            throw new CommonException(
                "Unable to detect design type to get CSS. Model given: {class}",
                [
                    "class" => get_class($model)
                ]
            );
        }

        $id = sprintf(
            "%s-%s",
            str_replace([".", " "], ["", "-"], $selector),
            $type
        );

        if (array_key_exists($id, self::$_css)) {
            return $this;
        }

        $css = "";
        //        $isUser = App::web()->getUser() !== null;
        //
        //        if ($isUser === true) {
        //            $css .= sprintf('<div id="%s">', $id);
        //            $css .= "<style>";
        //        }

        $css .= View::get(
            "design/" . $type,
            [
                "model"    => $model,
                "id"       => $id,
                "selector" => $selector,
            ]
        );

        //        if ($isUser === true) {
        //            $css .= '</style></div>';
        //        }

        self::$_css[$id] = $css;

        return $this;
    }
}