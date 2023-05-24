<?php

namespace core\entities\consultation;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Диагнозы консультации
 *
 * @property integer                            $id
 * @property integer                            $consultationId
 * @property int                                $sex
 * @property int                                $dateOfBirth
 * @property int                                $patientId
 * @property string                             $codeMkb
 * @property string                             $diagnosis
 * @property int                                $dateService
 * @property string                             $jobName
 * @property integer                            $created
 * @property integer                            $updated
 *
 * @property ConsultationDiagnosisDestination[] $consultationDiagnosisDestinations
 */
class ConsultationDiagnosis extends ActiveRecord
{
    public string $dateOfBirthStr = '';

    public string $dateServiceStr = '';


    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'consultation_diagnosis';
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultationDiagnosisDestinations(): ActiveQuery
    {
        return $this->hasMany(ConsultationDiagnosisDestination::className(), ['consultationDiagnosisId' => 'id'])
                    ->orderBy(['name' => SORT_ASC]);
    }


    public function afterFind()
    {
        if ($this->dateOfBirth != 0) {
            $this->dateOfBirthStr = date('d.m.Y', $this->dateOfBirth);
        }

        if ($this->dateService != 0) {
            $this->dateServiceStr = date('d.m.Y', $this->dateService);
        }

        parent::afterFind();
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
     * @param int    $consultationId
     * @param int    $sex
     * @param int    $dateOfBirth
     * @param int    $patientId
     * @param string $codeMkb
     * @param string $diagnosis
     * @param int    $dateService
     * @param string $jobName
     *
     * @return self
     */
    public static function create(
        int    $consultationId,
        int    $sex,
        int    $dateOfBirth,
        int    $patientId,
        string $codeMkb,
        string $diagnosis,
        int    $dateService,
        string $jobName
    ): ConsultationDiagnosis {
        $item = new self();

        $item->consultationId = $consultationId;
        $item->sex            = $sex;
        $item->dateOfBirth    = $dateOfBirth;
        $item->patientId      = $patientId;
        $item->codeMkb        = $codeMkb;
        $item->diagnosis      = $diagnosis;
        $item->dateService    = $dateService;
        $item->jobName        = $jobName;

        return $item;
    }
}