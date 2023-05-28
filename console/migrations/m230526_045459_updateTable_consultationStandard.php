<?php

use core\entities\consultation\ConsultationDiagnosis;
use core\entities\consultation\ConsultationDiagnosisDestination;
use yii\db\Migration;

/**
 * Class m230526_045459_updateTable_consultationStandard
 */
class m230526_045459_updateTable_consultationStandard extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(ConsultationDiagnosisDestination::tableName(), 'statusStandard', $this->smallInteger());
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(ConsultationDiagnosisDestination::tableName(), 'statusStandard');
    }
}
