<?php

use core\entities\standard\StandardFederal;
use yii\db\Migration;

/**
 * Class m230528_114330_createTable_standardFederal
 */
class m230528_114330_createTable_standardFederal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(StandardFederal::tableName(), [
            'id'            => $this->primaryKey(),
            'mkb10Id'       => $this->integer()->notNull(),
            'destinationId' => $this->integer()->notNull(),
            'code'          => $this->string()->notNull(),
            'value'         => $this->integer()->notNull(),
            'isImportant'   => $this->boolean(),
        ]);

        $this->createIndex(
            '{{%idx_standard_federal_mkb10Id}}',
            StandardFederal::tableName(),
            'mkb10Id'
        );

        $this->createIndex(
            '{{%idx_standard_federal_destinationId}}',
            StandardFederal::tableName(),
            'destinationId'
        );
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(StandardFederal::tableName());
    }
}
