<?php

namespace commands;

use system\App;
use system\base\Logger;
use system\console\Command;

/**
 * Builds a repository
 *
 * @package commands
 */
class BuildCommand extends Command
{

    /**
     * Prefix for release GIT branch
     */
    const RELEASE_PREFIX = "release.";

    /**
     * Name of GIT branch for build
     *
     * @var string
     */
    private $_branch = "master";

    /**
     * Name of GIT branch for rollback
     *
     * @var string
     */
    private $_prevBranch = "master";

    /**
     * Runs the command
     *
     * @param string[] $args command arguments
     *
     * @return bool
     */
    public function run($args)
    {
        if (!$this->_checkFolders()) {
            exit();
        }

        $this->_setBranches($args)->_gitCheckout($this->_branch);

        $migrateCommand = new MigrateCommand;
        $publicStaticCommand = new PublicStaticCommand;

        if (!$migrateCommand->run($args) || !$publicStaticCommand->run($args)) {
            Logger::log("Errors during building", Logger::LEVEL_ERROR, "console.build");

            $this->_gitCheckout($this->_prevBranch);
            Logger::log("Rollback to branch {$this->_prevBranch}", Logger::LEVEL_INFO, "console.build");

            return false;
        }

        Logger::log("Build completed successfully", Logger::LEVEL_INFO, "console.build");
        return true;
    }

    /**
     * Sets names of GIT branches for build and rollback
     *
     * @param string[] $args command arguments
     *
     * @return BuildCommand
     */
    private function _setBranches($args)
    {
        if (App::console()->config->isDebug) {
            if (!empty($args[0])) {
                $this->_branch = $args[0];
            }
        } else {
            $this->_branch = self::RELEASE_PREFIX . App::console()->config->release->current;
            $this->_prevBranch = self::RELEASE_PREFIX . App::console()->config->release->prev;
        }

        return $this;
    }

    /**
     * Checks basic folders
     *
     * @return bool
     */
    private function _checkFolders()
    {
        $logs = App::console()->config->rootDir . DIRECTORY_SEPARATOR . "logs";
        if (!file_exists($logs) && !mkdir($logs, 0777)) {
            echo "	> Unable to create folder \"logs\"\n";
            return false;
        }

        $backups = App::console()->config->rootDir . DIRECTORY_SEPARATOR . "backups";
        if (!file_exists($backups) && !mkdir($backups, 0777)) {
            Logger::log("Unable to create folder \"backups\"", Logger::LEVEL_ERROR, "console.build");
            return false;
        }

        $vendors = App::console()->config->rootDir . DIRECTORY_SEPARATOR . "vendors";
        if (!file_exists($vendors) && !mkdir($vendors, 0777)) {
            Logger::log("Unable to create folder \"vendors\"", Logger::LEVEL_ERROR, "console.build");
            return false;
        }

        return true;
    }

    /**
     * Builds GIT branch
     *
     * @param string $branch GIT branch name
     *
     * @return BuildCommand
     */
    private function _gitCheckout($branch)
    {
        Logger::log("Building from branch {$this->_branch}", Logger::LEVEL_INFO, "console.build");

        $command = "
			git add .;
			git reset --hard;
			git fetch --all -p;
			git checkout {$branch};
			git reset --hard origin/{$branch};
			chmod 777 c;
			php /root/composer.phar update;
		";
        exec($command);

        return $this;
    }
}