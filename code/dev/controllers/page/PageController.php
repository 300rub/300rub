<?php

namespace ss\controllers\page;

use ss\application\App;
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

        $html = $this->_getPageHtml();

        if ($this->_isUseMemcached() === true) {
            App::getInstance()->getMemcached()->set(
                $this->_getMemcachedKey(),
                $html
            );
        }

        return $html;
    }

    /**
     * Gets page HTML
     *
     * @return string
     */
    private function _getPageHtml()
    {
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

        return $this->render(
            'layout/page',
            [
                'icon'           => '/img/favicon.ico',
                'content'        => $content,
                'title'          => 'Test title',
                'keywords'       => 'Test keywords',
                'description'    => 'Test description',
                'css'            => $this->getCss(),
                'js'             => $this->getJs(),
                'html'           => $this->getHtml(),
                'less'           => $this->getLess(),
                'isUser'         => $isUser,
                'generatedCss'   => $sectionCss,
                'generatedJs'    => $sectionJs,
                'headerCode'     => $this->_getSettingsValueByType(
                    SettingsModel::CODE_HEADER
                ),
                'bodyTopCode'    => $this->_getSettingsValueByType(
                    SettingsModel::CODE_BODY_TOP
                ),
                'bodyBottomCode' => $this->_getSettingsValueByType(
                    SettingsModel::CODE_BODY_BOTTOM
                ),
                'initJs'         => $this->_getInitJs($sectionId),
            ]
        );
    }

    /**
     * Gets init JS
     *
     * @param int $sectionId Section ID
     *
     * @return string
     */
    private function _getInitJs($sectionId)
    {
        $isUser = $this->isUser();

        $token = '';
        if ($isUser === true) {
            $token = App::getInstance()->getUser()->getToken();
        }

        $isBlockSection = false;
        if ($this->getBlockSection() > 0) {
            $isBlockSection = true;
        }

        return $this->render(
            'layout/js/page',
            [
                'language'
                     => App::getInstance()->getLanguage()->getActiveId(),
                'errorMessages'
                     => App::getInstance()->getValidator()->getErrorMessages(),
                'token'          => $token,
                'sectionId'      => $sectionId,
                'isUser'         => $isUser,
                'isBlockSection' => $isBlockSection,
            ]
        );
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
                'section/line',
                [
                    'id'            => $line,
                    'lineStructure' => $this->_getLineStructure($lineStructure)
                ]
            );
        }

        return $this->render(
            'section/section',
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
                            'section/lineBlock',
                            [
                                'width' => $item['width'],
                                'left'  => $item['left'],
                                'html'  => $item['html'],
                            ]
                        );

                        break;
                    case 'container':
                        $html .= $this->render(
                            'section/lineBlockContainer',
                            [
                                'width' => $item['width'],
                                'left'  => $item['left'],
                                'data'  => $this->_getLineStructure(
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
}
