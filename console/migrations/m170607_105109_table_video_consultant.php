<?php

use yii\db\Migration;


class m170607_105109_table_video_consultant extends Migration
{
    public function up()
    {
        $this->createTable('video_consultant', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull()->defaultValue(0),
            'lang' => $this->string(2)->defaultValue("ru"),
            'title' => $this->string(128)->notNull(),
            'img_url' => $this->string(255)->notNull()->defaultValue(''),
            'video_url' => $this->string(255)->notNull()->defaultValue(''),
            'short_descr' => $this->string(255)->notNull(),
            'published' => $this->smallInteger(1)->defaultValue(0),
            'sort' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ], 'ENGINE = INNODB AUTO_INCREMENT = 1 CHARACTER SET utf8 COLLATE utf8_general_ci');
    }

    public function down()
    {
        $this->dropTable('video_consultant');
    }
}
