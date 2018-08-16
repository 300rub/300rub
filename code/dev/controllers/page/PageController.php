<?php

namespace ss\controllers\page;

use ss\application\App;
use ss\application\exceptions\NotFoundException;
use ss\controllers\page\_abstract\AbstractPageController;
use ss\models\sections\SectionModel;

/**
 * PageController
 */
class PageController extends AbstractPageController
{

    /**
     * Gets login page
     *
     * @return string
     *
     * @throws NotFoundException
     */
    public function run()
    {
        $token = '';
        $content = '';
        $sectionCss = [];
        $sectionJs = [];
        $isUser = $this->isUser();
        $sectionId = 0;

        $this->_setSectionModel();
        $sectionModel = App::getInstance()->getSite()->getActiveSection();

        if ($sectionModel !== null) {
            $sectionModel->setStructureAndStatic();
            $content = $this->_getCommonContent($sectionModel);
            $sectionCss = $sectionModel->getCss();
            $sectionJs = $sectionModel->getJs();
            $sectionId = $sectionModel->getId();
        }

        if ($isUser === true) {
            $token = App::getInstance()->getUser()->getToken();
            $content .= $this->_getUserContent();
        }

        $content .= $this->getContentFromTemplate(
            'templates/templates',
            [
                'isUser' => $isUser
            ]
        );

        $this->setStaticMap('static');

        $layoutData = [];
        $layoutData['content'] = $content;
        $layoutData['title'] = 'Test title';
        $layoutData['keywords'] = 'Test keywords';
        $layoutData['description'] = 'Test description';
        $layoutData['css'] = $this->getCss();
        $layoutData['js'] = $this->getJs();
        $layoutData['less'] = $this->getLess();
        $layoutData['language']
            = App::getInstance()->getLanguage()->getActiveId();
        $layoutData['errorMessages']
            = App::getInstance()->getValidator()->getErrorMessages();
        $layoutData['token'] = $token;
        $layoutData['sectionId'] = $sectionId;
        $layoutData['isUser'] = $isUser;
        $layoutData['generatedCss'] = $sectionCss;
        $layoutData['generatedJs'] = $sectionJs;
        $layoutData['version'] = $this->getVersion();


        return $this->getContentFromTemplate('page/layout', $layoutData);
    }

    /**
     * Gets Section models
     *
     * @return PageController
     */
    private function _setSectionModel()
    {
        $site = App::getInstance()->getSite();
        $requestUri = $site->getUri();

        if (strlen($requestUri) === 0
            || strpos($requestUri, '/') === false
        ) {
            $site->setActiveSection(
                SectionModel::model()->main()->withRelations(['*'])->find()
            );
            return $this;
        }

        $explode = explode('/', $requestUri);

        $site->setActiveSection(
            SectionModel::model()
                ->byLanguage(App::getInstance()->getLanguage()->getActiveId())
                ->byAlias($explode[1])
                ->withRelations(['*'])
                ->find()
        );
        return $this;
    }

    /**
     * Gets common content
     *
     * @param SectionModel $sectionModel Section model
     *
     * @return string
     */
    private function _getCommonContent($sectionModel)
    {
        $structure = $sectionModel->getStructure();

        $lineHtml = '';
        foreach ($structure as $line => $lineStructure) {
            $lineHtml .= $this->getContentFromTemplate(
                'page/line',
                [
                    'id'        => $line,
                    'structure' => $lineStructure
                ]
            );
        }

        return $this->getContentFromTemplate(
            'page/section',
            [
                'id'      => $sectionModel->getId(),
                'content' => $lineHtml
            ]
        );
    }

    /**
     * Gets content for user only
     *
     * @return string
     */
    private function _getUserContent()
    {
        $language = App::getInstance()->getLanguage();

        return $this->getContentFromTemplate(
            'page/userButtons',
            [
                'isDisplaySections'
                    => $this->hasAnySectionOperations(),
                'isDisplayBlocks'
                    => $this->hasAnyBlockOperations(),
                'logoutYes'
                    => $language->getMessage('user', 'logoutYes'),
                'logoutNo'
                    => $language->getMessage('user', 'logoutNo'),
                'logoutConfirmText'
                    => $language->getMessage('user', 'logoutConfirmText')
            ]
        );
    }
}
