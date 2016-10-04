<?php

namespace testS\commands;

use testS\applications\App;
use testS\components\Db;
use testS\components\exceptions\MigrationException;
use Exception;

/**
 * Applies migrations
 *
 * @package testS\commands
 */
class MigrateCommand extends AbstractCommand
{

	/**
	 * Is necessary to insert test information
	 * Works only in debug mode
	 *
	 * @var bool
	 */
	public $isTestData = true;

	/**
	 * New migrations
	 *
	 * @var string[]
	 */
	private $_migrations = [];

	/**
	 * All sites
	 *
	 * @var array
	 */
	private $_sites = [];

	/**
	 * Runs the command
	 *
	 * @param string[] $args command arguments
	 *
	 * @throws Exception
	 */
	public function run($args = [])
	{
		try {
			$this
				->_setNewMigrations()
				->_setSites();
		} catch (Exception $e) {
			throw $e;
		}

		try {
			$this
				->_applyMigration()
				->_updateVersions();
		} catch (Exception $e) {
			App::console()->output($e->getMessage(), true);

			try {
				App::console()->output("DB rollback has been started");
				// rollback
			} catch (Exception $e) {
				throw $e;
			}
		}
	}

	/**
	 * Sets the list of non-applied migrations
	 *
	 * @return MigrateCommand
	 */
	private function _setNewMigrations()
	{
		$versions = [];
		$rows = Db::fetchAll("SELECT * " . "FROM `migrations`");
		foreach ($rows as $row) {
			$versions[] = $row["version"];
		}

		$migrations = opendir(__DIR__ . "/../migrations");
		while (false !== ($file = readdir($migrations))) {
			if (strpos($file, "M") === 0) {
				$version = str_replace(".php", "", $file);
				if (App::getApplication()->config->isDebug || !in_array($version, $versions)) {
					$this->_migrations[] = $version;
				}
			}
		}

		return $this;
	}

	/**
	 * Sets sites
	 *
	 * @return MigrateCommand
	 */
	private function _setSites()
	{
		$rows = Db::fetchAll("SELECT * " . "FROM `sites`");
		foreach ($rows as $row) {
			$this->_sites[] = $row;
		}

		return $this;
	}

	/**
	 * Applies the migrations
	 *
	 * @throws MigrationException
	 *
	 * @return MigrateCommand
	 */
	private function _applyMigration()
	{
		if (!$this->_migrations || !$this->_sites) {
			return $this;
		}

		sort($this->_migrations);
		foreach ($this->_sites as $site) {
			if (!Db::setPdo($site["dbHost"], $site["dbUser"], $site["dbPassword"], $site["dbName"])) {
				throw new MigrationException(
					"Unable to connect with DB for applying migrations
					with host: {host}, user: {user}, password: {password}, name: {name}",
					[
						"host"     => $site["dbHost"],
						"user"     => $site["dbUser"],
						"password" => $site["dbPassword"],
						"name"     => $site["dbName"],
					]
				);
			}

			foreach ($this->_migrations as $migrationName) {
				/**
				 * @var \testS\migrations\AbstractMigration $migration
				 */
				$migrationFullName = "\\testS\\migrations\\{$migrationName}";
				$migration = new $migrationFullName;
				if (!$migration->isSkip) {
					$migration->up();
				}
			}
		}

		return $this;
	}

	/**
	 * Version's update
	 *
	 * @return MigrateCommand
	 *
	 * @throws MigrationException
	 */
	private function _updateVersions()
	{
		if (
		!Db::setPdo(
			App::getApplication()->config->db->host,
			App::getApplication()->config->db->user,
			App::getApplication()->config->db->password,
			App::getApplication()->config->db->name
		)
		) {
			throw new MigrationException(
				"Unable to connect with DB for updating versions
					with host: {host}, user: {user}, password: {password}, name: {name}",
				[
					"host"     => App::getApplication()->config->db->host,
					"user"     => App::getApplication()->config->db->user,
					"password" => App::getApplication()->config->db->password,
					"name"     => App::getApplication()->config->db->name,
				]
			);
		}

		try {
			Db::startTransaction();

			foreach ($this->_migrations as $migration) {
				if (!Db::execute("INSERT" . " INTO `migrations` (version) VALUES(?)", [$migration])) {
					throw new MigrationException(
						"UUnable to update version with migration: {migration}",
						[
							"migration" => $migration,
						]
					);
				}
			}
		} catch (MigrationException $e) {
			Db::rollbackTransaction();
		}

		Db::commitTransaction();

		return $this;
	}
}