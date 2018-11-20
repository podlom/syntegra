<?php

use yii\db\Migration;

/**
 * Class m180109_124913_create_table_answers
 */
class m180109_124913_create_table_answers extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('answers', [
            'id' => $this->primaryKey(),
            'id_question' => $this->integer(),
            'json_data' => $this->text(),
            'created_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
        ]);
    }

    public function down()
    {
        echo "m180109_124913_create_table_answers cannot be reverted.\n";
        $this->dropTable('answers');
        return false;
    }

}
