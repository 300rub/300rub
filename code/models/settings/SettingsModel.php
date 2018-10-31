<?php

namespace ss\models\settings;

use ss\application\components\db\Table;
use ss\application\exceptions\ModelException;
use ss\models\settings\_base\AbstractSettingsModel;

/**
 * Model for working with table "settings"
 */
class SettingsModel extends AbstractSettingsModel
{

    /**
     * Gets new model
     *
     * @return SettingsModel
     */
    public static function model()
    {
        return new self;
    }

    /**
     * Gets type
     *
     * @param string $key Key
     *
     * @return string
     *
     * @throws ModelException
     */
    public function getTypeValue($key = null)
    {
        if ($key === null) {
            $key = $this->get('type');
        }

        $list = $this->getTypeList();
        if (array_key_exists($key, $list) === true) {
            return $list[$key];
        }

        throw new ModelException(
            'Unable to find type: {key}',
            [
                'key' => $key
            ]
        );
    }

    /**
     * Selects by type
     *
     * @param string $type Type
     *
     * @return SettingsModel
     */
    public function byType($type)
    {
        $this->getTable()->addWhere(
            sprintf(
                '%s.type = :type',
                Table::DEFAULT_ALIAS
            )
        );
        $this->getTable()->addParameter('type', $type);

        return $this;
    }
}
