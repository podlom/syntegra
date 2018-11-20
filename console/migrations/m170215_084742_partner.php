<?php

use yii\db\Migration;

class m170215_084742_partner extends Migration
{
    public function up()
    {
        $this->createTable('partner', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull(),
            'title' => $this->string(255)->notNull(),
            'lang' => $this->string(2)->defaultValue("ru"),
            'published' => $this->smallInteger(1)->defaultValue(0),
            'created_at' => $this->timestamp()->defaultValue(null),
            'updated_at' => 'timestamp on update current_timestamp',
        ], 'ENGINE = INNODB AUTO_INCREMENT = 1 CHARACTER SET utf8 COLLATE utf8_general_ci');

        $this->createIndex('idx__partner_lang', 'partner', 'lang');
        $this->createIndex('idx__partner_published', 'partner', 'published');
    }

    public function down()
    {
        $this->dropTable('partner');
    }
}
