<?php

namespace core\entities\standard;

use core\entities\dictionary\Destination;
use core\entities\dictionary\Mkb10;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Стандарт Москвы
 *
 * @property integer     $id
 * @property integer     $mkb10Id
 * @property integer     $destinationId
 * @property string      $categoryName
 * @property string      $name
 * @property string      $type
 * @property bool        $isImportant
 * @property string      $criterion
 *
 * @property Mkb10       $mkb10
 * @property Destination $destination
 */
class StandardMoscow extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'standard_moscow';
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
     * @param string $categoryName
     * @param string $name
     * @param string $type
     * @param bool   $isImportant
     * @param string $criterion
     *
     * @return StandardMoscow
     */
    public static function create(
        int    $mkb10Id,
        int    $destinationId,
        string $categoryName,
        string $name,
        string $type,
        bool   $isImportant,
        string $criterion
    ): StandardMoscow {
        $item = new self();

        $item->mkb10Id       = $mkb10Id;
        $item->destinationId = $destinationId;
        $item->categoryName  = $categoryName;
        $item->type          = $type;
        $item->name          = $name;
        $item->isImportant   = $isImportant;
        $item->criterion     = $criterion;

        return $item;
    }
}