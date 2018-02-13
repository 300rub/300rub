<?php

namespace ss\migrations;

use ss\application\App;
use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates table for storing information about domains
 */
class M160301000010Domains extends AbstractMigration
{

    /**
     * Flag. If it is true - it will be skipped in common applying
     *
     * @var boolean
     */
    public $isSkip = true;

    /**
     * Applies migration
     *
     * @return void
     */
    public function apply()
    {
        $this
            ->createTable(
                'domains',
                [
                    'id'     => self::TYPE_PK,
                    'siteId' => self::TYPE_FK,
                    'name'   => self::TYPE_STRING,
                    'isMain' => self::TYPE_BOOL
                ]
            )
            ->createForeignKey(
                'domains',
                'siteId',
                'sites',
                self::FK_CASCADE,
                self::FK_CASCADE
            );
    }

    /**
     * Inserts test data
     *
     * @return void
     */
    public function insertData()
    {
        $dbObject = App::getInstance()->getDb();
        $domains = App::getInstance()->getConfig()->getValue(['domains']);
        foreach ($domains as $domain) {
            $dbObject->execute(
                'INSERT ' . 'INTO domains (siteId, name, isMain) VALUES (?, ?, ?)',
                [
                    $domain['siteId'],
                    $domain['name'],
                    $domain['isMain'],
                ]
            );
        }
    }
}
