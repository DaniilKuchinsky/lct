<?php

use core\entities\dictionary\Mkb10;
use yii\db\Migration;

/**
 * Class m230525_083131_createTable_mkb10
 */
class m230525_083131_createTable_mkb10 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Mkb10::tableName(), [
            'id'   => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Mkb10::tableName());
    }
}
