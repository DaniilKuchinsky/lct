<?php

namespace core\entities\consultation;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Назначения диагноза консультации
 *
 * @property integer $id
 * @property integer $consultationDiagnosisId
 * @property string  $name
 * @property integer $created
 * @property integer $updated
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
}