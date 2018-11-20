<?php

use yii\db\Migration;


class m170516_085812_coworking_request extends Migration
{
    public function up()
    {
        $this->createTable('coworking_request', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(55)->notNull(),
            'last_name' => $this->string(55)->notNull(),
            'email' => $this->string(255)->notNull(),
            'server' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->defaultValue(null),
        ], 'ENGINE = INNODB AUTO_INCREMENT = 1 CHARACTER SET utf8 COLLATE utf8_general_ci');
    }

    public function down()
    {
        $this->dropTable('coworking_request');
    }
}
