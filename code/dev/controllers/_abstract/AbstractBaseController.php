<?php

namespace ss\controllers\_abstract;

use ss\application\App;

/**
 * Basic abstract class for working with controllers
 */
abstract class AbstractBaseController
{

    /**
     * Protocols
     */
    const PROTOCOL_HTTP = 'http';
    const PROTOCOL_HTTPS = 'https';

    /**
     * Runs controller
     *
     * @return array
     */
    abstract public function run();

    /**
     * Gets content from view
     *
     * @param string $viewFile View file
     * @param array  $data     Data
     *
     * @return string
     */
    protected function getContentFromTemplate($viewFile, $data = [])
    {
        return App::getInstance()->getView()->get($viewFile, $data);
    }

    /**
     * Redirects
     *
     * @param string $uri      URI
     * @param string $host     HOST
     * @param string $protocol Protocol
     *
     * @return void
     *
     * @SuppressWarnings(PMD.ExitExpression)
     */
    protected function redirect($uri, $host = null, $protocol = null)
    {
        header(
            sprintf(
                'Location: %s',
                $this->generateAbsoluteUrl($uri, $host, $protocol)
            )
        );
        exit;
    }

    /**
     * Generates absolute url
     *
     * @param string $uri      URI
     * @param string $host     HOST
     * @param string $protocol Protocol
     *
     * @return string
     */
    protected function generateAbsoluteUrl($uri, $host = null, $protocol = null)
    {
        if ($host === null) {
            $host = App::getInstance()
                ->getSuperGlobalVariable()
                ->getServerValue('HTTP_HOST');
        }

        if ($protocol === null) {
            $protocol = App::getInstance()
                ->getSuperGlobalVariable()
                ->getServerValue('SERVER_PROTOCOL');

            $protocol = strtolower(
                substr(
                    $protocol,
                    0,
                    strpos($protocol, '/')
                )
            );
        }

        return sprintf(
            '%s://%s%s',
            $protocol,
            $host,
            $uri
        );
    }
}
