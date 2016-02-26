<?php

namespace system\web;

/**
 * Class Json for working with JSON structure
 *
 * @package system\web
 */
class Json
{

    /**
     * JSON's structure
     *
     * @var array
     */
    private $_json = [];

    /**
     * Sets JSON's structure
     *
     * @param array $json JSON's structure
     *
     * @return Json
     */
    public function setJson($json)
    {
        $this->_json = $json;
        return $this;
    }

    /**
     * Gets JSON's structure
     *
     * @return array
     */
    public function getJson()
    {
        return $this->_json;
    }

    /**
     * Sets description
     *
     * @param string $description Description
     *
     * @return Json
     */
    public function setDescription($description)
    {
        $this->_json["description"] = $description;
        return $this;
    }

    /**
     * Sets title
     *
     * @param string $title Title
     *
     * @return Json
     */
    public function setTitle($title)
    {
        $this->_json["title"] = $title;
        return $this;
    }

    /**
     * Sets panel list
     *
     * @param array  $items           List of items
     * @param string $icon            Icon
     * @param string $itemContent     Item content action
     * @param string $itemHandler     Item handler action
     * @param string $designContent   Design content action
     * @param string $designHandler   Design handler action
     * @param string $settingsContent Settings content action
     * @param string $settingsHandler Settings handler action
     * @param string $addLabel        Add button label
     *
     * @return Json
     */
    public function setPanelList(
        $items,
        $icon,
        $itemContent,
        $itemHandler,
        $designContent = null,
        $designHandler = null,
        $settingsContent = null,
        $settingsHandler = null,
        $addLabel = null
    )
    {
        $this->_json["list"] = [
            "items"       => $items,
            "icon"        => $icon,
            "item" => [
                "content" => $itemContent
            ]
            "itemContent" => $itemContent,
            "itemHandler" => $itemHandler
        ];

        if ($designContent && $designHandler) {
            $this->_json["list"]["designContent"] = $designContent;
            $this->_json["list"]["designHandler"] = $designHandler;
        }

        if ($settingsContent && $settingsHandler) {
            $this->_json["list"]["settingsContent"] = $settingsContent;
            $this->_json["list"]["settingsHandler"] = $settingsHandler;

            if ($addLabel) {
                $this->_json["list"]["addLabel"] = $addLabel;
            }
        }

        return $this;
    }
}