<?php

namespace testS\commands;

use testS\applications\App;
use testS\components\Db;
use testS\components\exceptions\MigrationException;
use testS\migrations\M160301000000Sites;
use testS\migrations\M160302000000Migrations;

/**
 * Clear DB command
 *
 * @package testS\commands
 */
class ClearDbCommand extends AbstractCommand
{

	/**
	 * Runs the command
	 *
	 * @param string[] $args command arguments
	 */
	public function run($args = [])
	{
		self::clear();
	}

	/**
	 * Clear DB script
	 */
	public static function clear()
	{
        $app = App::getInstance();

		exec(
			sprintf(
				'mysql -u %s -p%s -h %s -e "DROP DATABASE IF EXISTS %s"',
                $app->getConfig(["db", "localhost", "user"]),
                $app->getConfig(["db", "localhost", "password"]),
                $app->getConfig(["db", "localhost", "host"]),
                $app->getConfig(["db", "localhost", "name"])
			)
		);
		exec(
			sprintf(
				'mysql -u %s -p%s -h %s -e "CREATE DATABASE IF NOT EXISTS %s"',
                $app->getConfig(["db", "localhost", "user"]),
                $app->getConfig(["db", "localhost", "password"]),
                $app->getConfig(["db", "localhost", "host"]),
                $app->getConfig(["db", "localhost", "name"])
			)
		);

        exec(
            sprintf(
                'mysql -u %s -p%s -h %s -e "DROP DATABASE IF EXISTS %s"',
                $app->getConfig(["db", "system", "user"]),
                $app->getConfig(["db", "system", "password"]),
                $app->getConfig(["db", "system", "host"]),
                $app->getConfig(["db", "system", "name"])
            )
        );
        exec(
            sprintf(
                'mysql -u %s -p%s -h %s -e "CREATE DATABASE IF NOT EXISTS %s"',
                $app->getConfig(["db", "system", "user"]),
                $app->getConfig(["db", "system", "password"]),
                $app->getConfig(["db", "system", "host"]),
                $app->getConfig(["db", "system", "name"])
            )
        );

        exec(
            sprintf(
                'mysql -u %s -p%s -h %s -e "DROP DATABASE IF EXISTS %s"',
                $app->getConfig(["db", "help", "user"]),
                $app->getConfig(["db", "help", "password"]),
                $app->getConfig(["db", "help", "host"]),
                $app->getConfig(["db", "help", "name"])
            )
        );
        exec(
            sprintf(
                'mysql -u %s -p%s -h %s -e "CREATE DATABASE IF NOT EXISTS %s"',
                $app->getConfig(["db", "help", "user"]),
                $app->getConfig(["db", "help", "password"]),
                $app->getConfig(["db", "help", "host"]),
                $app->getConfig(["db", "help", "name"])
            )
        );

		Db::setSystemPdo();

		$migration = new M160301000000Sites();
		$migration->up();
		$migration->insertData();

		$migration = new M160302000000Migrations();
		$migration->up();
	}
}