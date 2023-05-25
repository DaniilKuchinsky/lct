<?php

use core\entities\standard\StandardMoscow;
use yii\db\Migration;

/**
 * Class m230525_085008_createTable_standardMoscow
 */
class m230525_085008_createTable_standardMoscow extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(StandardMoscow::tableName(), [
            'id'            => $this->primaryKey(),
            'mkb10Id'       => $this->integer()->notNull(),
            'destinationId' => $this->integer()->notNull(),
            'categoryName'  => $this->string()->notNull(),
            'name'          => $this->string()->notNull(),
            'type'          => $this->string()->notNull(),
            'isImportant'   => $this->boolean(),
            'criterion'     => $this->text(),
        ]);

        $this->createIndex(
            '{{%idx_standard_moscow_mkb10Id}}',
            StandardMoscow::tableName(),
            'mkb10Id'
        );

        $this->createIndex(
            '{{%idx_standard_moscow_destinationId}}',
            StandardMoscow::tableName(),
            'destinationId'
        );
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(StandardMoscow::tableName());
    }
}
