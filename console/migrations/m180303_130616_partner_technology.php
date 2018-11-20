<?php

use yii\db\Migration;

/**
 * Class m180303_130616_partner_technology
 */
class m180303_130616_partner_technology extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('partner_technology', [
            'id' => $this->primaryKey(),
            'partner_id' => $this->integer()->notNull(),
            'technology_id' => $this->integer()->notNull(),
            'lang' => $this->string(2)->defaultValue("ru"),
            'sort' => $this->integer()->notNull()->defaultValue(0),
            'published' => $this->smallInteger(1)->defaultValue(0),
        ]);
    }

    public function down()
    {
        echo "m180303_130616_partner_technology cannot be reverted.\n";
        $this->dropTable('partner_technology');
    }

}
