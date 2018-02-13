<?php

namespace ss\controllers\page;

use ss\application\App;
use ss\controllers\_abstract\AbstractController;
use ss\models\sections\SectionModel;

/**
 * PageController
 */
class PageController extends AbstractController
{

    /**
     * Gets login page
     *
     * @return string
     */
    public function run()
    {
        $isUser = $this->isUser();

        $sectionModel = $this->_getSectionModel();
        $sectionModel->setStructureAndStatic();

        $token = '';
        $content = $this->_getCommonContent($sectionModel);

        if ($isUser === true) {
            $token = App::web()->getUser()->getToken();
            $content .= $this->_getUserContent();
        }

        if ($isUser === false) {
            $content .= $this->_getGuestContent();
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
        $layoutData['css'] = $this->_getCss();
        $layoutData['js'] = $this->_getJs();
        $layoutData['less'] = $this->_getLess();
        $layoutData['language']
            = App::web()->getLanguage()->getActiveId();
        $layoutData['errorMessages']
            = App::web()->getValidator()->getErrorMessages();
        $layoutData['token'] = $token;
        $layoutData['isUser'] = $isUser;
        $layoutData['generatedCss'] = $sectionModel->getCss();

        return $this->getContentFromTemplate('page/layout', $layoutData);
    }

    /**
     * Gets Section models
     *
     * @return SectionModel
     */
    private function _getSectionModel()
    {
        return SectionModel::model()->byId(1)->withRelations()->find();
    }

    /**
     * Gets CSS
     *
     * @return array
     */
    private function _getCss()
    {
        $isUser = $this->isUser();
        $config = App::getInstance()->getConfig();

        $cssList = $config->getValue(
            ['staticMap', 'common', 'libs', 'css']
        );
        if ($isUser === true) {
            $cssList = array_merge(
                $cssList,
                $config->getValue(
                    ['staticMap', 'admin', 'libs', 'css']
                )
            );
        }

        if (APP_ENV !== ENV_DEV) {
            $cssList[] = $config->getValue(
                ['staticMap', 'common', 'compiledCss']
            );
            if ($isUser === true) {
                $cssList[] = $config->getValue(
                    ['staticMap', 'admin', 'compiledCss']
                );
            }
        }

        return $cssList;
    }

    /**
     * Gets JS
     *
     * @return array
     */
    private function _getJs()
    {
        $isUser = $this->isUser();
        $config = App::getInstance()->getConfig();

        $jsList = $config->getValue(
            ['staticMap', 'common', 'libs', 'js']
        );

        if ($isUser === true) {
            $jsList = array_merge(
                $jsList,
                $config->getValue(
                    ['staticMap', 'admin', 'libs', 'js']
                )
            );
        }

        if (APP_ENV === ENV_DEV) {
            $jsList = array_merge(
                $jsList,
                $config->getValue(
                    ['staticMap', 'common', 'js']
                )
            );

            if ($isUser === false) {
                return $jsList;
            }

            return array_merge(
                $jsList,
                $config->getValue(
                    ['staticMap', 'admin', 'js']
                )
            );
        }

        $jsList[] = $config->getValue(
            ['staticMap', 'common', 'compiledJs']
        );

        if ($isUser === true) {
            $jsList[] = $config->getValue(
                ['staticMap', 'admin', 'compiledJs']
            );
        }

        return $jsList;
    }

    /**
     * Gets less
     *
     * @return array
     */
    private function _getLess()
    {
        if (APP_ENV !== ENV_DEV) {
            return [];
        }

        $config = App::getInstance()->getConfig();

        $less = [];

        $less[] = $config->getValue(
            ['staticMap', 'common', 'less']
        );
        if ($this->isUser() === true) {
            $less[] = $config->getValue(
                ['staticMap', 'admin', 'less']
            );
        }

        return $less;
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
     * Gets content for guest only
     *
     * @return string
     */
    private function _getGuestContent()
    {
        return $this->getContentFromTemplate('page/loginButton');
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
