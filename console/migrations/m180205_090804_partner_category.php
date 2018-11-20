<?php

use yii\db\Migration;

/**
 * Class m180205_090804_partner_category
 */
class m180205_090804_partner_category extends Migration
{



    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('partner_category', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull(),
            'title' => $this->string(255)->notNull(),
            'lang' => $this->string(2)->defaultValue("ru"),
            'published' => $this->smallInteger(1)->defaultValue(0),
            'sort' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultValue(null),
            'updated_at' => 'timestamp on update current_timestamp',
        ]);
    }

    public function down()
    {
        $this->dropTable('partner_category');
    }

}
