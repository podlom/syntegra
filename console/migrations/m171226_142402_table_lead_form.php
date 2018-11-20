<?php

use yii\db\Migration;


/**
 * Class m171226_142402_table_lead_form
 */
class m171226_142402_table_lead_form extends Migration
{
    public function up()
    {
        $this->createTable('lead_form', [
            'id' => $this->primaryKey(),
            'lang' => $this->string(2)->defaultValue("ru"),
            'title' => $this->string(255)->notNull(),
            'fields' => $this->text()->notNull(),
            'sort' => $this->integer()->notNull()->defaultValue(0),
            'published' => $this->smallInteger(1)->defaultValue(0),
            'created_at' => $this->timestamp()->defaultValue(null),
            'updated_at' => 'timestamp on update current_timestamp',
        ], 'ENGINE = INNODB AUTO_INCREMENT = 1 CHARACTER SET utf8 COLLATE utf8_unicode_ci');
    }

    public function down()
    {
        $this->dropTable('lead_form');
    }
}
