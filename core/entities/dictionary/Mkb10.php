<?php

namespace core\entities\dictionary;

use yii\db\ActiveRecord;

/**
 * МКБ-10
 *
 * @property integer $id
 * @property string  $name
 *
 */
class Mkb10 extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'dic_mkb_10';
    }


    /**
     * @param string $name
     *
     * @return self
     */
    public static function create(string $name): Mkb10
    {
        $item = new self();

        $item->name = $name;

        return $item;
    }
}