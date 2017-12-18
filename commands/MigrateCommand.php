<?php

namespace testS\commands;

use testS\application\App;
use testS\application\exceptions\MigrationException;
use testS\commands\_abstract\AbstractCommand;
use testS\migrations\AbstractMigration;

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
     * App::console()->output($e->getMessage(), true);
     * try {
     * App::console()->output("DB rollback has been started");
     * } catch (Exception $e) {
     * throw $e;
     * }
     *
     * @return void
     *
     * @throws \Exception
     */
    public function run()
    {
        try {
            App::getInstance()->getDb()->setSystemPdo();
            $this
                ->_setNewMigrations()
                ->_setSites();
        } catch (\Exception $e) {
            throw $e;
        }

        try {
            $this
                ->_applyMigration()
                ->_updateVersions();
        } catch (\Exception $e) {
            throw $e;
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
        $rows = App::getInstance()
            ->getDb()
            ->fetchAll('SELECT * ' . 'FROM `migrations`');
        foreach ($rows as $row) {
            $versions[] = $row['version'];
        }

        $files = scandir(__DIR__ . '/../migrations');
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
     * @return MigrateCommand
     */
    private function _setSites()
    {
        $this->_sites = App::getInstance()
            ->getDb()
            ->fetchAll('SELECT * ' . 'FROM `sites`');

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
        if (count($this->_migrations) === 0
            || count($this->_sites) === 0
        ) {
            return $this;
        }

        sort($this->_migrations);

        foreach ($this->_sites as $site) {
            App::getInstance()
                ->getDb()
                ->setPdo(
                    $site['dbHost'],
                    $site['dbUser'],
                    $site['dbPassword'],
                    $site['dbName']
                );

            foreach ($this->_migrations as $migrationName) {
                $migration = $this->_getMigrationByName($migrationName);
                if ($migration->isSkip === false) {
                    $migration->up();
                }
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
        $migrationFullName = '\\testS\\migrations\\' . $migrationName;
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

        $dbObject->setSystemPdo();

        try {
            $dbObject->startTransaction();

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
        } catch (MigrationException $e) {
            $dbObject->rollbackTransaction();
        }

        $dbObject->commitTransaction();

        return $this;
    }
}
