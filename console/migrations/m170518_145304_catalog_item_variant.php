<?php

use yii\db\Migration;


class m170518_145304_catalog_item_variant extends Migration
{
    public function up()
    {
        $this->createTable('catalog_item_variant', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'default' => $this->smallInteger(1)->defaultValue(0),
            'articul' => $this->string(255)->notNull(),
            'color_id' => $this->integer()->notNull(),
            'img_url' => $this->string(255)->notNull(),
            'sort' => $this->integer()->notNull(),
            'published' => $this->smallInteger(1)->defaultValue(0),
            'created_at' => $this->timestamp()->defaultValue(null),
            'updated_at' => 'timestamp on update current_timestamp',
        ], 'ENGINE = INNODB AUTO_INCREMENT = 1 CHARACTER SET utf8 COLLATE utf8_general_ci');

        $this->createIndex('idx__civ_product_id', 'catalog_item_variant', 'product_id');
        $this->createIndex('idx__civ_published', 'catalog_item_variant', 'published');
    }

    public function down()
    {
        $this->dropTable('catalog_item_variant');
    }
}
