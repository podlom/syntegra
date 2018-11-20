<?php

use yii\db\Migration;


class m170522_075159_catalog_subcategory1 extends Migration
{
    public function up()
    {
        $this->createTable('catalog_subcategory1', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'lang' => $this->string(2)->defaultValue("ru"),
            'published' => $this->smallInteger(1)->defaultValue(0),
            'created_at' => $this->timestamp()->defaultValue(null),
            'updated_at' => 'timestamp on update current_timestamp',
        ], 'ENGINE = INNODB AUTO_INCREMENT = 1 CHARACTER SET utf8 COLLATE utf8_general_ci');
    }

    public function down()
    {
        $this->dropTable('catalog_subcategory1');
    }
}
