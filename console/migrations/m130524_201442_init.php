<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id'                 => $this->primaryKey(),
            'email'              => $this->string()->notNull()->unique(),
            'authKey'            => $this->string(32)->notNull(),
            'passwordHash'       => $this->string()->notNull(),
            'passwordResetToken' => $this->string()->unique(),

            'status'  => $this->smallInteger()->notNull()->defaultValue(10),
            'created' => $this->integer()->notNull(),
            'updated' => $this->integer()->notNull(),
        ],                 $tableOptions);
    }


    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
