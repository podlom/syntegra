<?php

use yii\db\Migration;

/**
 * Class m180302_141919_reviews
 */
class m180302_141919_reviews extends Migration
{



    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('reviews', [
            'id' => $this->primaryKey(),
            'fullname' => $this->string(255),
            'work_place' => $this->string(255),
            'descripton' => $this->text(),
            'lang' => $this->string(2)->defaultValue("ru"),
            'sort' => $this->integer()->notNull()->defaultValue(0),
            'published' => $this->smallInteger(1)->defaultValue(0),
            'created_at' => $this->timestamp()->defaultValue(null),
            'updated_at' => 'timestamp on update current_timestamp',
        ]);
    }

    public function down()
    {
        echo "m180302_141919_reviews cannot be reverted.\n";

        $this->dropTable('reviews');
    }

}
