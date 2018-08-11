<?php

namespace ss\controllers\site;

use ss\controllers\site\_abstract\AbstractController;

/**
 * CreateController to work with create page
 */
class CreateController extends AbstractController
{

    /**
     * Gets site page
     *
     * @return string
     */
    public function run()
    {
        $content = $this->getContentFromTemplate('site/index', []);
        $title = 'CREATE Test title';
        $keywords = 'CREATE Test keywords';
        $description = 'CREATE Test description';

        $pageHtml = $this->getPageHtml(
            $content,
            $title,
            $keywords,
            $description
        );

        return $pageHtml;
    }
}
