<?php

namespace ss\application\instances;

use ss\application\instances\_abstract\AbstractApplication;
use ss\commands\_abstract\AbstractCommand;
use ss\application\exceptions\CommonException;

/**
 * Class for working with console
 */
class Console extends AbstractApplication
{

    /**
     * Runs command
     *
     * @throws \Exception
     * @throws CommonException
     *
     * @return void
     */
    public function run()
    {
        try {
            $startTime = microtime(true);

            $args = $this->getSuperGlobalVariable()->getServerValue('argv');
            if (empty($args[1]) === true) {
                throw new CommonException('Incorrect command');
            }

            $commandName = str_replace('/', '\\', $args[1]);
            array_shift($args);
            array_shift($args);

            $className = '\\ss\\commands\\' . $commandName;

            $this
                ->_getCommandByClassName($className)
                ->setArguments($args)
                ->run();

            $time = number_format((microtime(true) - $startTime), 3);

            echo sprintf('Time: %s seconds', $time);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Gets command by class name
     *
     * @param string $className Class name
     *
     * @return AbstractCommand
     */
    private function _getCommandByClassName($className)
    {
        return new $className;
    }
}
