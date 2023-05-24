<?php

namespace core\entities\consultation;

use core\helpers\consultation\ConsultationHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Консультация
 *
 * @property integer                 $id
 * @property string                  $uniqueId
 * @property string                  $fileName
 * @property int                     $status
 * @property integer                 $created
 * @property integer                 $updated
 *
 * @property ConsultationDiagnosis[] $consultationDiagnoses
 */
class Consultation extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'consultation';
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultationDiagnoses(): ActiveQuery
    {
        return $this->hasMany(ConsultationDiagnosis::className(), ['consultationId' => 'id'])
                    ->orderBy(['dateService' => SORT_DESC]);
    }


    public function behaviors(): array
    {
        return [
            [
                'class'      => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created', 'updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ],
            ],
        ];
    }


    /**
     * @param string $fileName
     *
     * @return self
     * @throws \yii\base\Exception
     */
    public static function create(string $fileName): Consultation
    {
        $item = new self();

        $item->fileName = $fileName;
        $item->uniqueId = ConsultationHelper::generateUniqueId();
        $item->status   = ConsultationHelper::STATUS_NEW;

        return $item;
    }


    /**
     * @param int $newStatus
     *
     */
    public function setStatus(int $newStatus)
    {
        $this->status = $newStatus;
    }

}