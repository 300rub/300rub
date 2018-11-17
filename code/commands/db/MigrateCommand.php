<?php

namespace ss\commands\db;

use ss\application\App;
use ss\application\components\db\Db;
use ss\application\exceptions\MigrationException;
use ss\commands\_abstract\AbstractCommand;
use ss\migrations\_abstract\AbstractMigration;
use ss\migrations\system\Migrations;
use ss\models\system\MigrationModel;
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
    private $_migrationsUp = [];

    /**
     * Migrations to roll back
     *
     * @var MigrationModel[]
     */
    private $_migrationsDown = [];

    /**
     * All sites
     *
     * @var array
     */
    private $_sites = [];

    /**
     * Migration files
     *
     * @var array
     */
    private $_files = [];

    /**
     * Current migration
     *
     * @var string
     */
    private $_currentMigration = '';

    /**
     * Current SQL
     *
     * @var string
     */
    private $_currentSql = '';

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
            ->setSites()
            ->setFiles()
            ->applyMigration();
    }

    /**
     * Sets sites
     *
     * @param string[] $siteNames Site names
     *
     * @return MigrateCommand
     */
    public function setSites(array $siteNames = [])
    {
        $this->_sites = [];

        $dbObject = App::getInstance()->getDb();

        $dbObject->setActivePdoKey(
            Db::CONFIG_DB_NAME_SYSTEM
        );

        $sites = new SiteModel();

        if (count($siteNames) > 0) {
            $sites->addIn('name', $siteNames);
        }

        $sites = $sites->findAll(true);

        foreach ($sites as $site) {
            $dbWriteName = $dbObject->getWriteDbName(
                $site['t_dbName']
            );
            $dbReadName = $dbObject->getReadDbName(
                $site['t_dbName']
            );

            $this->_sites[] = [
                'id'         => $site['t_id'],
                'name'       => $site['t_name'],
                'dbHost'     => $site['t_dbHost'],
                'dbUser'     => $site['t_dbUser'],
                'dbPassword' => $site['t_dbPassword'],
                'dbName'     => $dbWriteName
            ];

            if ($dbWriteName === $dbReadName) {
                continue;
            }

            $this->_sites[] = [
                'id'         => $site['t_id'],
                'name'       => $site['t_name'],
                'dbHost'     => $site['t_dbHost'],
                'dbUser'     => $site['t_dbUser'],
                'dbPassword' => $site['t_dbPassword'],
                'dbName'     => $dbReadName
            ];
        }

        return $this;
    }

    /**
     * Sets files
     *
     * @return MigrateCommand
     */
    public function setFiles()
    {
        $this->_files = [];

        $files = scandir(__DIR__ . '/../../migrations');
        foreach ($files as $file) {
            if ($file === '.'
                || $file === '..'
                || strpos($file, 'M') !== 0
            ) {
                continue;
            }

            $this->_files[] = str_replace('.php', '', $file);
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
    public function applyMigration()
    {
        if (count($this->_sites) === 0) {
            return $this;
        }

        $dbObject = App::getInstance()->getDb();

        foreach ($this->_sites as $site) {
            $dbObject
                ->addPdo(
                    $site['dbHost'],
                    $site['dbUser'],
                    $site['dbPassword'],
                    $site['dbName']
                )
                ->setActivePdoKey($site['dbName'])
                ->beginTransaction($site['dbName']);

            try {
                $this
                    ->output('----------------------------')
                    ->output(
                        sprintf(
                            'ID: %s',
                            $site['id']
                        )
                    )
                    ->output(
                        sprintf(
                            'Name: %s',
                            $site['name']
                        )
                    )
                    ->output(
                        sprintf(
                            'DB: %s',
                            $site['dbName']
                        )
                    );

                $this->_down();
                $this->_uo();

                $dbObject
                    ->commit($site['dbName'])
                    ->deletePdo($site['dbName']);
            } catch (\Exception $e) {
                $dbObject
                    ->rollBack($site['dbName'])
                    ->deletePdo($site['dbName']);

                throw new MigrationException(
                    'An error occurred while applying migration ' .
                    'for site ID: {siteId}, name: {siteName} ' .
                    'Error: {error}, file: {file}, line: {line}. ' .
                    'Migration: {migration}, SQL: {sql}',
                    [
                        'siteId'    => $site['id'],
                        'siteName'  => $site['name'],
                        'error'     => $e->getMessage(),
                        'file'      => $e->getFile(),
                        'line'      => $e->getLine(),
                        'migration' => $this->_currentMigration,
                        'sql'       => $this->_currentSql,
                    ]
                );
            }
        }

        $this->output('----------------------------');

        return $this;
    }

    /**
     * Applies new migrations
     *
     * @return MigrateCommand
     * 
     * @throws MigrationException
     */
    private function _uo()
    {
        $this->output('Up:');

        $this->_setMigrationsUp();
        if (count($this->_migrationsUp) === 0) {
            $this->output('-', true);
            return $this;
        }

        foreach ($this->_migrationsUp as $migrationName) {
            $migration = $this->_getMigrationByName($migrationName);

            $this->output($migrationName);

            $this->_currentMigration = $migrationName;

            $sqlUp = $migration->generateSqlUp();

            $this->_currentSql = $sqlUp;

            $sqlDown = $migration->generateSqlDown();

            $migration->execute($sqlUp);

            MigrationModel::model()
                ->set(
                    [
                        'version' => $migrationName,
                        'down'    => $sqlDown,
                    ]
                )
                ->save();
        }
        
        return $this;
    }

    /**
     * Sets the list of non-applied migrations
     *
     * @return MigrateCommand
     */
    private function _setMigrationsUp()
    {
        $this->_migrationsUp = [];

        $versions = [];

        $migrations = MigrationModel::model()->findAll(true);
        foreach ($migrations as $migration) {
            $versions[] = $migration['t_version'];
        }

        foreach ($this->_files as $file) {
            if (in_array($file, $versions) === false) {
                $this->_migrationsUp[] = $file;
            }
        }

        sort($this->_migrationsUp);

        return $this;
    }

    /**
     * Rolls back migrations
     *
     * @return MigrateCommand
     *
     * @throws MigrationException
     */
    private function _down()
    {
        $this->output('Down:');

        $this->_setMigrationsDown();
        if (count($this->_migrationsDown) === 0) {
            $this->output('-', true);
            return $this;
        }

        foreach ($this->_migrationsDown as $migrationModel) {
            $version = $migrationModel->get('version');
            $sqlDown = $migrationModel->get('down');

            $this->_currentMigration = $version;
            $this->_currentSql = $sqlDown;

            $this->output($version);

            $migrationModel->delete();

            if (empty($sqlDown) === true) {
                continue;
            }

            $migration = new Migrations();
            $migration->execute($sqlDown);
        }

        return $this;
    }

    /**
     * Sets the list of migrations to roll back
     *
     * @return MigrateCommand
     */
    private function _setMigrationsDown()
    {
        $this->_migrationsDown = [];

        $migrations = MigrationModel::model()->findAll();
        foreach ($migrations as $migration) {
            $version = $migration->get('version');
            if (in_array($version, $this->_files) === false) {
                $this->_migrationsDown[$version] = $migration;
            }
        }

        krsort($this->_migrationsDown);

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
}
