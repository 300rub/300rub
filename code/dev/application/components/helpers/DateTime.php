<?php

namespace ss\application\components\helpers;

/**
 * Class to work with dates
 */
class DateTime
{

    /**
     * Types
     */
    const TYPE_NONE = 0;
    const TYPE_DMY = 1;

    /**
     * DateTime
     *
     * @var \DateTime
     */
    private $_dateTime = null;

    /**
     * Format list
     *
     * @var array
     */
    private $_formatList = [
        self::TYPE_NONE => '',
        self::TYPE_DMY  => 'd/m/Y',
    ];

    /**
     * Gets format list
     *
     * @return array
     */
    public function getFormatList()
    {
        return [
            self::TYPE_NONE => 'None',
            self::TYPE_DMY  => 'dd/mm/yyyy',
        ];
    }

    /**
     * DateTime constructor.
     *
     * @param \DateTime $dateTime DateTime
     */
    public function __construct(\DateTime $dateTime = null)
    {
        if ($dateTime === null) {
            $dateTime = new \DateTime();
        }

        $this->_dateTime = $dateTime;
    }

    /**
     * Creates object
     *
     * @param \DateTime $dateTime DateTime
     *
     * @return DateTime
     */
    public static function create(\DateTime $dateTime = null)
    {
        return new self($dateTime);
    }

    /**
     * Gets formatted value
     *
     * @param int $formatType Type
     *
     * @return string
     */
    public function getValue($formatType)
    {
        if (array_key_exists($formatType, $this->_formatList) === false) {
            return '';
        }

        return $this->_dateTime->format($this->_formatList[$formatType]);
    }
}
