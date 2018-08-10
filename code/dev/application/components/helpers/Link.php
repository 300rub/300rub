<?php

namespace ss\application\components\helpers;

use ss\application\App;

/**
 * Class to work with links
 */
class Link
{

    /**
     * Parses HTML links
     *
     * @param string $html HTML
     *
     * @return string
     */
    public function parseLinks($html)
    {
        preg_match_all('/\{\{section_[0-9]+\}\}/', $html, $matches);

        if (array_key_exists(0, $matches) === false
            || is_array($matches[0]) === false
            || count($matches[0]) === 0
        ) {
            return $html;
        }

        $site = App::getInstance()->getSite();
        if ($site === null) {
            return $html;
        }

        $search = array_unique($matches[0]);
        $replace = [];

        foreach ($search as $key => $value) {
            $sectionId = str_replace(['{{section_', '}}'], '', $value);
            $alias = $site
                ->getSectionById($sectionId)
                ->get('seoModel')
                ->get('alias');

            $replace[$key] = $alias;
        }

        return str_replace($search, $replace, $html);
    }

    /**
     * Generates a link
     *
     * @param string $link      Link
     * @param int    $sectionId Section ID
     *
     * @return string
     */
    public function generateLink($link, $sectionId = null)
    {
        if ($sectionId === null) {
            $sectionId = App::getInstance()
                ->getSite()
                ->getActiveSection()
                ->getId();
        }

        return sprintf(
            '/%s/{{section_%s}}/%s',
            App::getInstance()->getLanguage()->getActiveAlias(),
            $sectionId,
            $link
        );
    }
}
