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
     * Command's ending
     */
    const COMMAND_ENDING = 'Command';

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

            $commandName = ucfirst($args[1]);
            array_shift($args);
            array_shift($args);

            $className = '\\ss\\commands\\' .
                $commandName .
                self::COMMAND_ENDING;
            $this->output(
                sprintf(
                    'The command [%s] has been started',
                    $commandName
                ),
                false
            );

            $this
                ->_getCommandByClassName($className)
                ->setArguments($args)
                ->run();

            $time = number_format((microtime(true) - $startTime), 3);
            $this->output(
                sprintf(
                    'The command [%s] has been finished ' .
                    "successfully with time: [%s]\n",
                    $commandName,
                    $time
                ),
                false
            );
        } catch (\Exception $e) {
            $this->output($e->getMessage() . "\n", true);
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

    /**
     * Console output
     *
     * $output = "\e[0;33m" . date('Y-m-d H:i:s', time());
     * if ($isError === false) {
     * $output .= " \e[0;32m[success] ";
     * } else {
     * $output .= " \e[1;31m[error] ";
     * }
     *
     * $output .= "\e[0m" . $message;
     *
     * echo "\n{$output}";
     *
     * @param string $message Message
     * @param bool   $isError Error flag
     *
     * @return string
     */
    public function output($message, $isError)
    {
        return $message . (string)$isError;
    }
}
