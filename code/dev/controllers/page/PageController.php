<?php

namespace ss\controllers\page;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\application\exceptions\NotFoundException;
use ss\controllers\page\_abstract\AbstractPageController;
use ss\models\sections\SectionModel;
use ss\models\settings\SettingsModel;

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
        if ($this->isUser() === true) {
            return false;
        }

        $test = App::getInstance()
            ->getSuperGlobalVariable()
            ->getGetValue('test');
        if ($test !== null) {
            return false;
        }

        return true;
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

        $sectionModel = App::getInstance()
            ->getSite()
            ->getActiveSection();

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

        $isBlockSection = false;
        if ($this->getBlockSection() > 0) {
            $isBlockSection = true;
        }

        $this->setStaticMap('static');

        $layoutData = [];
        $layoutData['content'] = $content;
        $layoutData['templates'] = $this->render(
            'templates/templates',
            [
                'isUser' => $isUser
            ]
        );
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
        $layoutData['headerCode'] = $this->_getSettingsValueByType(
            SettingsModel::CODE_HEADER
        );
        $layoutData['bodyTopCode'] = $this->_getSettingsValueByType(
            SettingsModel::CODE_BODY_TOP
        );
        $layoutData['bodyBottomCode'] = $this->_getSettingsValueByType(
            SettingsModel::CODE_BODY_BOTTOM
        );
        $layoutData['isBlockSection'] = $isBlockSection;

        $html = $this->render('page/layout', $layoutData);

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
    private function _getSettingsValueByType($type)
    {
        $settingsModel = SettingsModel::model()->byType($type)->find();
        if ($settingsModel === null) {
            return null;
        }

        return $settingsModel->get('value');
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
            $lineHtml .= $this->render(
                'page/line',
                [
                    'id'            => $line,
                    'lineStructure' => $this->_getLineStructure($lineStructure)
                ]
            );
        }

        return $this->render(
            'page/section',
            [
                'id'      => $sectionModel->getId(),
                'content' => $lineHtml
            ]
        );
    }

    /**
     * Gets line structure
     *
     * @param array $structure Structure
     *
     * @return string
     */
    private function _getLineStructure($structure)
    {
        $html = '';

        foreach ($structure as $yData) {
            $lastY = 0;

            foreach ($yData as $item) {
                if (array_key_exists('type', $item) === false) {
                    continue;
                }

                switch ($item['type']) {
                    case 'block':
                        if ($lastY < $item['y']) {
                            $html .= $this->render(
                                'content/components/clear'
                            );
                            $lastY = $item['y'];
                        }

                        $html .= $this->render(
                            'page/lineBlock',
                            [
                                'item' => $item
                            ]
                        );

                        break;
                    case 'container':
                        $html .= $this->render(
                            'page/lineBlockContainer',
                            [
                                'item' => $item,
                                'data' => $this->_getLineStructure(
                                    $item['data']
                                )
                            ]
                        );

                        break;
                }
            }

            $html .= $this->render(
                'content/components/clear'
            );
        }

        return $html;
    }

    /**
     * Gets content for user only
     *
     * @return string
     */
    private function _getUserContent()
    {
        $language = App::getInstance()->getLanguage();

        return $this->render(
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
