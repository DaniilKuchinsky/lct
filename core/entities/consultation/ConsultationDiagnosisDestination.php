<?php

namespace core\entities\consultation;

use core\entities\standard\StandardMoscow;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Назначения диагноза консультации
 *
 * @property integer               $id
 * @property integer               $consultationDiagnosisId
 * @property string                $name
 * @property integer               $statusStandard
 * @property integer               $standardMoscowId
 * @property integer               $standardFederalId
 * @property integer               $created
 * @property integer               $updated
 *
 * @property ConsultationDiagnosis $consultationDiagnosis
 * @property StandardMoscow        $standardMoscow
 */
class ConsultationDiagnosisDestination extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'consultation_diagnosis_destination';
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultationDiagnosis(): ActiveQuery
    {
        return $this->hasOne(ConsultationDiagnosis::className(), ['id' => 'consultationDiagnosisId']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStandardMoscow(): ActiveQuery
    {
        return $this->hasOne(StandardMoscow::className(), ['id' => 'standardMoscowId']);
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
     * @param int    $consultationDiagnosisId
     * @param string $name
     *
     * @return self
     */
    public static function create(int $consultationDiagnosisId, string $name): ConsultationDiagnosisDestination
    {
        $item = new self();

        $item->consultationDiagnosisId = $consultationDiagnosisId;
        $item->name                    = $name;

        return $item;
    }


    /**
     * @param int      $newStatus
     * @param int|null $standardMoscowId
     * @param int|null $standardFederalId
     */
    public function setStatusStandard(int $newStatus, ?int $standardMoscowId, ?int $standardFederalId)
    {
        $this->statusStandard    = $newStatus;
        $this->standardMoscowId  = $standardMoscowId;
        $this->standardFederalId = $standardFederalId;
    }
}