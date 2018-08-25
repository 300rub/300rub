<?php

namespace ss\models\blocks\image\_base;


use ss\application\components\valueGenerator\ValueGenerator;
use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "designImageSimple"
 */
abstract class AbstractDesignImageSimpleModel extends AbstractModel
{

    /**
     * Alignments
     */
    const ALIGNMENT_LEFT = 0;
    const ALIGNMENT_CENTER = 1;
    const ALIGNMENT_RIGHT = 2;

    /**
     * Align list values
     *
     * @var array
     */
    protected $alignListValues = [
        self::ALIGNMENT_LEFT   => '',
        self::ALIGNMENT_CENTER => 'align-center',
        self::ALIGNMENT_RIGHT  => 'align-right'
    ];

    /**
     * Gets alignment list
     *
     * @return array
     */
    public function getAlignmentList()
    {
        return [
            self::ALIGNMENT_LEFT   => '',
            self::ALIGNMENT_CENTER => '',
            self::ALIGNMENT_RIGHT  => ''
        ];
    }

    /**
     * Gets labels
     *
     * @return array
     */
    public static function getLabels()
    {
        return [

        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'designImageSimple';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'containerDesignBlockId'      => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'imageDesignBlockId' => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'descriptionDesignBlockId' => [
                self::FIELD_RELATION
                => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'descriptionDesignTextId' => [
                self::FIELD_RELATION
                => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'useDescription' => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            'alignment'          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        $this->alignListValues,
                        self::ALIGNMENT_LEFT
                    ]
                ],
            ]
        ];
    }
}
