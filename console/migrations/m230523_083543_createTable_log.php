<?php

use core\entities\log\LogEvent;
use yii\db\Migration;

/**
 * Class m230523_083543_createTable_log
 */
class m230523_083543_createTable_log extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(LogEvent::tableName(), [
            'id'          => $this->primaryKey(),
            'status'      => $this->smallInteger()->notNull(),
            'dateStart'   => $this->integer()->notNull(),
            'dateFinish'  => $this->integer(),
            'requestInfo' => $this->string(),
            'resultInfo'  => $this->text(),
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(LogEvent::tableName());
    }
}
