<?php

use core\entities\dictionary\Destination;
use yii\db\Migration;

/**
 * Class m230525_083138_createTable_destination
 */
class m230525_083138_createTable_destination extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Destination::tableName(), [
            'id'   => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Destination::tableName());
    }
}
