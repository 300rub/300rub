<?php

namespace ss\commands\db;

use ss\application\App;
use ss\application\components\db\Db;
use ss\application\exceptions\MigrationException;
use ss\commands\_abstract\AbstractCommand;
use ss\migrations\_abstract\AbstractMigration;
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
            ->setSites()
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
            $this->_sites[] = [
                'id'         => $site['t_id'],
                'name'       => $site['t_name'],
                'dbHost'     => $site['t_dbHost'],
                'dbUser'     => $site['t_dbUser'],
                'dbPassword' => $site['t_dbPassword'],
                'dbName'     => $dbObject->getWriteDbName(
                    $site['t_dbName']
                )
            ];

            $this->_sites[] = [
                'id'         => $site['t_id'],
                'name'       => $site['t_name'],
                'dbHost'     => $site['t_dbHost'],
                'dbUser'     => $site['t_dbUser'],
                'dbPassword' => $site['t_dbPassword'],
                'dbName'     => $dbObject->getReadDbName(
                    $site['t_dbName']
                )
            ];
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
                $this->_setNewMigrations();
                if (count($this->_migrations) === 0) {
                    continue;
                }

                sort($this->_migrations);

                foreach ($this->_migrations as $migrationName) {
                    $migration = $this->_getMigrationByName($migrationName);
                    if ($migration->isSkip === true) {
                        continue;
                    }

                    $sqlUp = $migration->generateSqlUp();
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
     * Sets the list of non-applied migrations
     *
     * @return MigrateCommand
     */
    private function _setNewMigrations()
    {
        $this->_migrations = [];

        $versions = [];

        $migrations = MigrationModel::model()->findAll(true);
        foreach ($migrations as $migration) {
            $versions[] = $migration['t_version'];
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
