<?php

namespace ss\models\help;

use ss\application\App;
use ss\application\exceptions\NotFoundException;
use ss\models\help\_base\AbstractPageModel;

/**
 * Model for working with table "pages" (help DB)
 */
class PageModel extends AbstractPageModel
{


    /**
     * Type
     */
    const TYPE = 'page';

    /**
     * Gets PageModel
     *
     * @return PageModel
     */
    public static function model()
    {
        return new self;
    }

    /**
     * Gets AbstractPageModel
     *
     * @throws NotFoundException
     *
     * @return AbstractPageModel
     */
    protected function getLanguageModel()
    {
        if ($this->languageModel === null) {
            $this->languageModel = LanguagePageModel::model()
                ->byAlias($this->getAlias())
                ->find();

            if ($this->languageModel === null) {
                throw new NotFoundException(
                    App::getInstance()->getLanguage()->getMessage(
                        'site',
                        'helpPageNotFound'
                    )
                );
            }
        }

        return $this->languageModel;
    }

    /**
     * Generates breadcrumbs
     *
     * @return array
     */
    protected function generateBreadcrumbs()
    {
        $language = App::getInstance()->getLanguage();

        $breadcrumbs = [
            [
                'name' => $language->getMessage('site', 'home'),
                'uri'  => sprintf(
                    '/%s',
                    $language->getActiveAlias()
                ),
            ],
            [
                'name' => $language->getMessage('site', 'help'),
                'uri'  => sprintf(
                    '/%s/help',
                    $language->getActiveAlias()
                ),
            ],
        ];

        $breadcrumbs[] = [
            'name' => $this->getName(),
        ];

        return $breadcrumbs;
    }
}
