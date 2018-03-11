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
        $isUser = $this->isUser();

        $sectionModel = $this->_getSectionModel();

        if ($sectionModel === null
            && $isUser === false
        ) {
            throw new NotFoundException(
                App::web()->getLanguage()->getMessage('common', 'notFound')
            );
        }

        if ($sectionModel !== null) {
            $sectionModel->setStructureAndStatic();
            $content = $this->_getCommonContent($sectionModel);
            $sectionCss = $sectionModel->getCss();
        }

        if ($isUser === true) {
            $token = App::web()->getUser()->getToken();
            $content .= $this->_getUserContent();
        }

        $content .= $this->getContentFromTemplate(
            'templates/templates',
            [
                'isUser' => $isUser
            ]
        );

        $layoutData['content'] = $content;
        $layoutData['title'] = 'Test title';
        $layoutData['keywords'] = 'Test keywords';
        $layoutData['description'] = 'Test description';
        $layoutData['css'] = $this->getCss();
        $layoutData['js'] = $this->getJs();
        $layoutData['less'] = $this->getLess();
        $layoutData['language']
            = App::web()->getLanguage()->getActiveId();
        $layoutData['errorMessages']
            = App::web()->getValidator()->getErrorMessages();
        $layoutData['token'] = $token;
        $layoutData['isUser'] = $isUser;
        $layoutData['generatedCss'] = $sectionCss;

        return $this->getContentFromTemplate('page/layout', $layoutData);
    }

    /**
     * Gets Section models
     *
     * @return SectionModel
     */
    private function _getSectionModel()
    {
        $requestUri = App::web()
            ->getSuperGlobalVariable()
            ->getServerValue('REQUEST_URI');

        $requestUri = trim($requestUri, '/');

        if (strlen($requestUri) === 0
            || strpos($requestUri, '/') === false
        ) {
            return SectionModel::model()->main()->withRelations()->find();
        }

        $explode = explode('/', $requestUri);

        return SectionModel::model()
            ->byLanguage(App::web()->getLanguage()->getActiveId())
            ->byUrl($explode[1])
            ->withRelations()
            ->find();
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
        $language = App::web()->getLanguage();

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
