<?php

namespace ss\controllers\page\_abstract;

use ss\application\App;
use ss\controllers\_abstract\AbstractController;

/**
 * Abstract Page Controller
 */
abstract class AbstractPageController extends AbstractController
{

    /**
     * Gets CSS
     *
     * @return array
     */
    protected function getCss()
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
    protected function getJs()
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
    protected function getLess()
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
}
