<?php

use core\entities\consultation\ConsultationDiagnosisDestination;
use yii\db\Migration;

/**
 * Class m230528_115940_updateTable_consultationDiagnosisStandard
 */
class m230528_115940_updateTable_consultationDiagnosisStandard extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(ConsultationDiagnosisDestination::tableName(), 'standardMoscowId', $this->integer());
        $this->addColumn(ConsultationDiagnosisDestination::tableName(), 'standardFederalId', $this->integer());
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(ConsultationDiagnosisDestination::tableName(), 'standardMoscowId');
        $this->dropColumn(ConsultationDiagnosisDestination::tableName(), 'standardFederalId');
    }
}
