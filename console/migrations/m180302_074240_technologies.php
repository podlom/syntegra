<?php

use yii\db\Migration;

/**
 * Class m180302_074240_technologies
 */
class m180302_074240_technologies extends Migration
{


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('technologies', [
            'id' => $this->primaryKey(),
            'img' => $this->string(255),
            'title' => $this->string(255),
            'slug' => $this->string(255),
            'lang' => $this->string(2)->defaultValue("ru"),
            'sort' => $this->integer()->notNull()->defaultValue(0),
            'published' => $this->smallInteger(1)->defaultValue(0),
        ]);
    }

    public function down()
    {
        echo "m180302_074240_technologies cannot be reverted.\n";

        $this->dropTable('technologies');
    }

}
