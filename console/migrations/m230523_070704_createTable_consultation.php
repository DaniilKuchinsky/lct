<?php

use core\entities\consultation\Consultation;
use yii\db\Migration;

/**
 * Class m230523_070704_createTable_consultation
 */
class m230523_070704_createTable_consultation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Consultation::tableName(), [
            'id'       => $this->primaryKey(),
            'uniqueId' => $this->string()->notNull()->unique(),
            'fileName' => $this->string()->notNull(),
            'status'   => $this->smallInteger()->notNull(),
            'created'  => $this->integer(),
            'updated'  => $this->integer(),
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(Consultation::tableName());
    }
}
