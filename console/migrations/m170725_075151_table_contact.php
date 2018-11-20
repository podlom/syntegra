<?php

use yii\db\Migration;


class m170725_075151_table_contact extends Migration
{
    public function up()
    {
        $this->createTable('contact' , [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull(),
            'email' => $this->string(255)->notNull(),
            'message' => $this->text()->notNull(),
            'server' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->defaultValue(null),
        ], 'ENGINE = INNODB AUTO_INCREMENT = 1 CHARACTER SET utf8 COLLATE utf8_general_ci');
    }

    public function down()
    {
        $this->dropTable('contact');
    }
}
