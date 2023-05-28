<?php

namespace core\entities\standard;

use core\entities\dictionary\Destination;
use core\entities\dictionary\Mkb10;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Стандарт Федеральный
 *
 * @property integer     $id
 * @property integer     $mkb10Id
 * @property integer     $destinationId
 * @property string      $code
 * @property int         $value
 * @property bool        $isImportant
 *
 * @property Mkb10       $mkb10
 * @property Destination $destination
 */
class StandardFederal extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'standard_federal';
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMkb10(): ActiveQuery
    {
        return $this->hasOne(Mkb10::className(), ['id' => 'mkb10Id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestination(): ActiveQuery
    {
        return $this->hasOne(Destination::className(), ['id' => 'destinationId']);
    }


    /**
     * @param int    $mkb10Id
     * @param int    $destinationId
     * @param string $code
     * @param int    $value
     * @param bool   $isImportant
     *
     * @return StandardFederal
     */
    public static function create(
        int    $mkb10Id,
        int    $destinationId,
        string $code,
        int    $value,
        bool   $isImportant
    ): StandardFederal {
        $item = new self();

        $item->mkb10Id       = $mkb10Id;
        $item->destinationId = $destinationId;
        $item->code          = $code;
        $item->value         = $value;
        $item->isImportant   = $isImportant;

        return $item;
    }
}