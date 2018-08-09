<?php

namespace ss\commands\db;

use ss\application\App;
use ss\commands\_abstract\AbstractCommand;
use ss\models\_abstract\AbstractModel;

/**
 * Load DEV fixtures command
 */
class ImportDevFixturesCommand extends AbstractCommand
{

    /**
     * Order of fixtures loading
     *
     * @var string[]
     */
    private $_fixtureOrder = [
        'user'
            => '\\ss\\models\\user\\UserModel',
    ];

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        $dbList = [
            'help'
        ];

        foreach ($dbList as $dbName) {
            $this->load($dbName);
        }
    }

    /**
     * Clear DB script
     *
     * @param string $type Type
     *
     * @return void
     */
    public function load($type)
    {
        $config = App::getInstance()->getConfig();
        $dbObject = App::getInstance()->getDb();

        $dbObject->setPdo(
            $config->getValue(['db', $type, 'host']),
            $config->getValue(['db', $type, 'user']),
            $config->getValue(['db', $type, 'password']),
            $config->getValue(['db', $type, 'name'])
        );

        $dbObject->execute('SET GLOBAL FOREIGN_KEY_CHECKS=0;');

        foreach ($this->_fixtureOrder as $fixture => $modelName) {
            $filePath = __DIR__ .
                '/../../fixtures/' .
                $type .
                '/' .
                $fixture .
                '.php';

            if (file_exists($filePath) === false) {
                continue;
            }

            $records = include $filePath;
            foreach ($records as $record) {
                $this
                    ->_getModelByName($modelName)
                    ->set($record)
                    ->save();
            }
        }

        $dbObject->execute('SET GLOBAL FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Gets model by name
     *
     * @param string $modelName Model name
     *
     * @return AbstractModel
     */
    private function _getModelByName($modelName)
    {
        return new $modelName;
    }
}
