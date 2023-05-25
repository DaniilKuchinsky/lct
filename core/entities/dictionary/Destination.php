<?php

namespace core\entities\dictionary;

use yii\db\ActiveRecord;

/**
 * Назначения
 *
 * @property integer $id
 * @property string  $name
 *
 */
class Destination extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'dic_destination';
    }


    /**
     * @param string $name
     *
     * @return self
     */
    public static function create(string $name): Destination
    {
        $item = new self();

        $item->name = $name;

        return $item;
    }
}