<?php

use yii\db\Migration;


class m170719_135721_table_block extends Migration
{
    public function up()
    {
        $this->createTable('block', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull()->defaultValue(0),
            'slug' => $this->string(255)->notNull(),
            'lang' => $this->string(2)->defaultValue("ru"),
            'title' => $this->string(255)->notNull(),
            'body' => $this->text()->notNull(),
            'sort' => $this->integer()->notNull()->defaultValue(0),
            'published' => $this->smallInteger(1)->defaultValue(0),
            'created_at' => $this->timestamp()->defaultValue(null),
            'updated_at' => 'timestamp on update current_timestamp',
        ], 'ENGINE = INNODB AUTO_INCREMENT = 1 CHARACTER SET utf8 COLLATE utf8_general_ci');

        $this->addForeignKey('fk-category_id-catalog_category',
            'block',
            'category_id',
            'catalog_category',
            'id',
            'CASCADE',
            'CASCADE');
    }

    public function down()
    {
        $this->dropTable('block');
    }
}
