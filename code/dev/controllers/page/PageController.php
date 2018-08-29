<?php

namespace ss\controllers\page;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\application\exceptions\NotFoundException;
use ss\controllers\page\_abstract\AbstractPageController;
use ss\models\sections\SectionModel;
use ss\models\settings\SettingsModel;
use ss\models\user\UserEventModel;

/**
 * PageController
 */
class PageController extends AbstractPageController
{

    /**
     * Gets Memcached Key
     *
     * @return string
     */
    private function _getMemcachedKey()
    {
        $requestUri = App::getInstance()
            ->getSuperGlobalVariable()
            ->getServerValue('REQUEST_URI');

        $site = App::getInstance()->getSite();

        return md5($site->getId() . $site->get('version') . $requestUri);
    }

    /**
     * Is able to use Memcached
     *
     * @return bool
     */
    private function _isUseMemcached()
    {
        if ($this->isUser() === false) {
            return true;
        }

        return false;
    }

    /**
     * Gets login page
     *
     * @return string
     *
     * @throws NotFoundException
     */
    public function run()
    {
        if ($this->_isUseMemcached() === true) {
            $memcachedResult = App::getInstance()
                ->getMemcached()
                ->get($this->_getMemcachedKey());
            if ($memcachedResult !== false) {
                return $memcachedResult;
            }
        }

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
        $layoutData['headerCode'] = $this
            ->_getSettingsByType(
                SettingsModel::CODE_HEADER
            )
            ->get('value');
        $layoutData['bodyTopCode'] = $this
            ->_getSettingsByType(
                SettingsModel::CODE_BODY_TOP
            )
            ->get('value');
        $layoutData['bodyBottomCode'] = $this
            ->_getSettingsByType(
                SettingsModel::CODE_BODY_BOTTOM
            )
            ->get('value');

        $html = $this->getContentFromTemplate('page/layout', $layoutData);

        if ($this->_isUseMemcached() === true) {
            App::getInstance()->getMemcached()->set(
                $this->_getMemcachedKey(),
                $html
            );
        }

        return $html;
    }

    /**
     * Gets settings model by type
     *
     * @param string $type Type
     *
     * @return SettingsModel
     *
     * @throws NotFoundException
     */
    private function _getSettingsByType($type)
    {
        $settingsModel = SettingsModel::model()->byType($type)->find();
        if ($settingsModel === null) {
            throw new NotFoundException(
                'Unable to find settings model by type: {type}',
                [
                    'type' => $type
                ]
            );
        }

        return $settingsModel;
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
                'canRelease' => $this->hasSettingsOperation(
                    Operation::SETTINGS_USER_CAN_RELEASE
                ),
                'isDisplaySections'
                    => $this->hasAnySectionOperations(),
                'isDisplayBlocks'
                    => $this->hasAnyBlockOperations(),
                'logoutYes'
                    => $language->getMessage('user', 'logoutYes'),
                'logoutNo'
                    => $language->getMessage('user', 'logoutNo'),
                'logoutConfirmText'
                    => $language->getMessage('user', 'logoutConfirmText'),
                'releaseButton'
                    => $language->getMessage('release', 'buttonName'),
                'sectionsButton'
                    => $language->getMessage('section', 'buttonName'),
                'blocksButton'
                    => $language->getMessage('block', 'buttonName'),
                'settingsButton'
                    => $language->getMessage('settings', 'buttonName'),
                'helpButton'
                    => $language->getMessage('help', 'buttonName'),
                'logoutButton'
                    => $language->getMessage('user', 'logoutButtonName'),
            ]
        );
    }
}
