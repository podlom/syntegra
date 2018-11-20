<?php

use yii\db\Migration;

/**
 * Class m180302_092431_team
 */
class m180302_092431_team extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('team', [
            'id' => $this->primaryKey(),
            'position' => $this->string(255),
            'img' => $this->string(255),
            'fullname' => $this->string(255),
            'descripton' => $this->text(),
            'lang' => $this->string(2)->defaultValue("ru"),
            'sort' => $this->integer()->notNull()->defaultValue(0),
            'published' => $this->smallInteger(1)->defaultValue(0),
        ]);
    }

    public function down()
    {
        echo "m180302_092431_team cannot be reverted.\n";

        $this->dropTable('team');
    }

}
