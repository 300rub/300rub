<?php

namespace testS\commands;

use testS\applications\App;
use testS\components\Db;
use testS\components\exceptions\MigrationException;
use Exception;

/**
 * Applies migrations
 *
 * @package commands
 */
class ClearDbCommand extends AbstractCommand
{

	/**
	 * Runs the command
	 *
	 * @param string[] $args command arguments
	 *
	 * @throws Exception
	 */
	public function run($args = [])
	{
        $config = App::getApplication()->config;

        $db = $config->db;

//        $command = 'mysql -u root -proot -h 127.0.0.1 -e "GRANT ALL PRIVILEGES ON project.* TO \'root\'@\'%\' IDENTIFIED BY \'root\'"';
//        exec($command);
//
//
//        $command = 'mysql -u root -proot -h 127.0.0.1 -e "CREATE DATABASE project"';
//        exec($command);

//        if (!Db::execute("DROP DATABASE IF EXISTS {$db->name}")) {
//            throw new MigrationException("Unable to delete DB");
//        }
//
//        if (!Db::execute("CREATE DATABASE IF NOT EXISTS ")) {
//            throw new MigrationException("Unable to create DB");
//        }
//
//        if (!Db::execute("GRANT ALL PRIVILEGES ON {$db->name}.* TO '{$db->user}'@'%' IDENTIFIED BY '{$db->pass}'")) {
//            throw new MigrationException("Unable to create DB");
//        }

//        if (!Db::setPdo($db->host, $db->user, $db->password, $db->name)) {
//            throw new MigrationException(
//                "Unable to connect with DB for applying migrations
//					with host: {host}, user: {user}, password: {password}, name: {name}",
//                [
//                    "host"     => $db->host,
//                    "user"     => $db->user,
//                    "password" => $db->password,
//                    "name"     => $db->name,
//                ]
//            );
//        }
//
//        $tables = [];
//
//        $rows = Db::fetchAll("SHOW TABLES FROM " . $db->name);
//        foreach ($rows as $row) {
//            foreach ($row as $key => $value) {
//                $tables[] = $value;
//            }
//        }
//
//        foreach ($tables as $table) {
//            if (!Db::execute("DROP" . " TABLE `{$table}`")) {
//                throw new MigrationException(
//                    "Unable to delete table: {table} from DB: {db}",
//                    [
//                        "table" => $table,
//                        "db"    => $db->name
//                    ]
//                );
//            }
//        }
	}
}