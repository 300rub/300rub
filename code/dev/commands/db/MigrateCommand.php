<?php

namespace ss\commands\db;

use ss\application\App;
use ss\application\exceptions\DbException;
use ss\application\exceptions\MigrationException;
use ss\commands\_abstract\AbstractCommand;
use ss\migrations\_abstract\AbstractMigration;
use ss\migrations\M160302000000Migrations;
use ss\models\system\SiteModel;

/**
 * Applies migrations
 */
class MigrateCommand extends AbstractCommand
{

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
     * @return void
     *
     * @throws \Exception
     */
    public function run()
    {
        $this
            ->setSites($this->getArg(0))
            ->applyMigration();
    }

    /**
     * Sets the list of non-applied migrations
     *
     * @return MigrateCommand
     */
    private function _setNewMigrations()
    {
        $this->_migrations = [];

        $versions = [];
        $rows = App::getInstance()
            ->getDb()
            ->fetchAll('SELECT * ' . 'FROM `migrations`');
        foreach ($rows as $row) {
            $versions[] = $row['version'];
        }

        $files = scandir(__DIR__ . '/../../migrations');
        foreach ($files as $file) {
            if ($file === '.'
                || $file === '..'
                || strpos($file, 'M') !== 0
            ) {
                continue;
            }

            $version = str_replace('.php', '', $file);
            if (in_array($version, $versions) === false) {
                $this->_migrations[] = $version;
            }
        }

        return $this;
    }

    /**
     * Sets sites
     *
     * @param string $siteName Site name
     *
     * @return MigrateCommand
     */
    public function setSites($siteName = null)
    {
        $dbObject = App::getInstance()->getDb();

        $dbObject->setSystemPdo();

        if ($siteName === null) {
            $this->_sites = $dbObject
                ->fetchAll('SELECT * ' . 'FROM `sites`');

            return $this;
        }

        $this->_sites = $dbObject
            ->fetchAll(
                sprintf(
                    'SELECT * ' . 'FROM `sites` WHERE `name` = "%s"',
                    $siteName
                )
            );

        return $this;
    }

    /**
     * Applies the migrations
     *
     * @throws MigrationException
     *
     * @return MigrateCommand
     */
    public function applyMigration()
    {
        if (count($this->_sites) === 0) {
            return $this;
        }

        foreach ($this->_sites as $site) {
            App::getInstance()
                ->getDb()
                ->setPdo(
                    $site['dbHost'],
                    $site['dbUser'],
                    $site['dbPassword'],
                    $site['dbName']
                );

            $dbObject = App::getInstance()->getDb();
            $dbObject->startTransaction();

            try {
                $this->_setNewMigrations();
                if (count($this->_migrations) === 0) {
                    continue;
                }

                sort($this->_migrations);

                foreach ($this->_migrations as $migrationName) {
                    $migration = $this->_getMigrationByName($migrationName);
                    if ($migration->isSkip === false) {
                        $migration->apply();
                    }
                }

                $this->_updateVersions();

                $dbObject->commitTransaction();
            } catch (\Exception $e) {
                $dbObject->rollbackTransaction();

                throw new MigrationException(
                    'An error occurred while applying migration ' .
                    'for site ID: {siteId}, name: {siteName} ' .
                    'Error: {error}, file: {file}, line: {line}',
                    [
                        'siteId'   => $site['id'],
                        'siteName' => $site['name'],
                        'error'    => $e->getMessage(),
                        'file'     => $e->getFile(),
                        'line'     => $e->getLine(),
                    ]
                );
            }
        }

        return $this;
    }

    /**
     * Gets migration by name
     *
     * @param string $migrationName Migration name
     *
     * @return AbstractMigration
     */
    private function _getMigrationByName($migrationName)
    {
        $migrationFullName = '\\ss\\migrations\\' . $migrationName;
        return new $migrationFullName;
    }

    /**
     * Version's update
     *
     * @throws MigrationException
     *
     * @return MigrateCommand
     */
    private function _updateVersions()
    {
        $dbObject = App::getInstance()->getDb();

        foreach ($this->_migrations as $migration) {
            $result = $dbObject->execute(
                'INSERT' . ' INTO `migrations` (version) VALUES(?)',
                [$migration]
            );

            if ($result === false) {
                throw new MigrationException(
                    'UUnable to update version with migration: {migration}',
                    [
                        'migration' => $migration,
                    ]
                );
            }
        }

        return $this;
    }
}
