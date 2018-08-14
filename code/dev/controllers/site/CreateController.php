<?php

namespace ss\controllers\site;

use ss\application\App;
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
        $language = App::getInstance()->getLanguage();

        $content = $this->getContentFromTemplate(
            'site/create',
            [
                'createSite' => $language->getMessage('site', 'createSiteButton')
            ]
        );
        $title = 'Dev';
        $keywords = '';
        $description = '';

        $pageHtml = $this->getPageHtml(
            $content,
            $title,
            $keywords,
            $description
        );

        return $pageHtml;
    }
}
