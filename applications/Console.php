<?php

/**
 * PHP version 7
 *
 * @category Applications
 * @package  Application
 * @author   Mikhail Vasilev <donvasilion@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     -
 */

namespace testS\applications;

use testS\commands\AbstractCommand;
use testS\components\exceptions\CommonException;
use Exception;

/**
 * Class for working with console
 *
 * @category Applications
 * @package  Application
 * @author   Mikhail Vasilev <donvasilion@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     -
 */
class Console extends AbstractApplication
{

    /**
     * Command's ending
     */
    const COMMAND_ENDING = "Command";

    /**
     * Runs command
     *
     * @throws Exception
     *
     * @return void
     */
    public function run()
    {
        try {
            $startTime = microtime(true);

            $args = $_SERVER['argv'];
            if (empty($args[1])) {
                throw new CommonException("Incorrect command");
            }

            $commandName = ucfirst($args[1]);
            array_shift($args);
            array_shift($args);

            $className = "\\testS\\commands\\" . $commandName . self::COMMAND_ENDING;
            $this->output("The command \"{$commandName}\" has been started");

            $command = $this->_getCommandByClassName($className);
            $command->run($args);

            $time = number_format(microtime(true) - $startTime, 3);
            App::console()->output(
                "The command \"{$commandName}\" has been finished " .
                "successfully with time: {$time}\n"
            );
        } catch (Exception $e) {
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
     * @param string $message Message
     * @param bool   $isError Error flag
     *
     * @return void
     */
    public function output($message, $isError = false)
    {
        return;

        $output = "\e[0;33m" . date("Y-m-d H:i:s", time());
        if ($isError === false) {
            $output .= " \e[0;32m[success] ";
        } else {
            $output .= " \e[1;31m[error] ";
        }
        $output .= "\e[0m" . $message;

        echo "\n{$output}";
    }
}