<?php

use core\entities\consultation\ConsultationDiagnosis;
use yii\db\Migration;

/**
 * Class m230523_070710_createTable_consultationDiagnosis
 */
class m230523_070710_createTable_consultationDiagnosis extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(ConsultationDiagnosis::tableName(), [
            'id'             => $this->primaryKey(),
            'consultationId' => $this->integer()->notNull(),
            'sex'            => $this->smallInteger()->notNull(),
            'dateOfBirth'    => $this->integer()->notNull(),
            'patientId'      => $this->integer()->notNull(),
            'codeMkb'        => $this->string()->notNull(),
            'diagnosis'      => $this->string()->notNull(),
            'dateService'    => $this->integer()->notNull(),
            'jobName'        => $this->string()->notNull(),
            'created'        => $this->integer(),
            'updated'        => $this->integer(),
        ]);

        $this->createIndex(
            '{{%idx_consultation_diagnosis_consultationId}}',
            ConsultationDiagnosis::tableName(),
            'consultationId'
        );
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(ConsultationDiagnosis::tableName());
    }
}
