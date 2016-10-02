<?php

namespace commands;

use applications\App;
use components\Db;
use components\exceptions\MigrationException;
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
        if (!Db::setPdo($db->host, $db->user, $db->password, $db->name)) {
            throw new MigrationException(
                "Unable to connect with DB for applying migrations
					with host: {host}, user: {user}, password: {password}, name: {name}",
                [
                    "host"     => $db->host,
                    "user"     => $db->user,
                    "password" => $db->password,
                    "name"     => $db->name,
                ]
            );
        }

        $tables = [];

        $rows = Db::fetchAll("SHOW TABLES FROM " . $db->name);
        foreach ($rows as $row) {
            foreach ($row as $key => $value) {
                $tables[] = $value;
            }
        }

        foreach ($tables as $table) {
            if (!Db::execute("DROP" . " TABLE `{$table}`")) {
                throw new MigrationException(
                    "Unable to delete table: {table} from DB: {db}",
                    [
                        "table" => $table,
                        "db"    => $db->name
                    ]
                );
            }
        }
	}
}