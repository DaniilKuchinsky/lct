<?php

use core\entities\consultation\ConsultationDiagnosisDestination;
use yii\db\Migration;

/**
 * Class m230523_070715_createTable_consultationDiagnosisDestination
 */
class m230523_070715_createTable_consultationDiagnosisDestination extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(ConsultationDiagnosisDestination::tableName(), [
            'id'                      => $this->primaryKey(),
            'consultationDiagnosisId' => $this->integer()->notNull(),
            'name'                    => $this->string()->notNull(),
            'created'                 => $this->integer(),
            'updated'                 => $this->integer(),
        ]);

        $this->createIndex(
            '{{%idx_consultation_diagnosis_destination_consultationDiagnosisId}}',
            ConsultationDiagnosisDestination::tableName(),
            'consultationDiagnosisId'
        );
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(ConsultationDiagnosisDestination::tableName());
    }
}
