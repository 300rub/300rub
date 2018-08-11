<?php

namespace ss\controllers\site;

use ss\controllers\site\_abstract\AbstractController;

/**
 * HelpController to work with help pages
 */
class HelpController extends AbstractController
{

    /**
     * Gets site page
     *
     * @return string
     */
    public function run()
    {
        $content = $this->getContentFromTemplate('site/index', []);
        $title = 'HELP Test title';
        $keywords = 'HELP Test keywords';
        $description = 'HELP Test description';

        $pageHtml = $this->getPageHtml(
            $content,
            $title,
            $keywords,
            $description
        );

        return $pageHtml;
    }
}
