<?php

namespace ss\migrations;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates feedback tables
 */
class M160321000000Feedback extends AbstractMigration
{

    /**
     * Applies migration
     *
     * @return void
     */
    protected function up()
    {
        $this
            ->createTable(
                'feedback',
                [
                    'id'                   => self::TYPE_PK,
                    'formId'               => self::TYPE_FK,
                    'subjectFormInstanceId' => self::TYPE_FK,
                    'subjectText'          => self::TYPE_STRING,
                    'host'                 => self::TYPE_STRING,
                    'port'                 => self::TYPE_SMALLINT_UNSIGNED,
                    'type'                 => self::TYPE_STRING_25,
                    'user'                 => self::TYPE_STRING,
                    'password'             => self::TYPE_STRING,
                ]
            )
            ->createForeignKey('feedback', 'formId', 'forms')
            ->createForeignKey(
                'feedback',
                'subjectFormInstanceId',
                'formInstances'
            );
    }

    /**
     * SQL down
     *
     * @return void
     */
    protected function down()
    {
    }
}
