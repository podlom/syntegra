<?php

use yii\db\Migration;

/**
 * Class m171227_091608_group_questions
 */
class m171227_091608_group_questions extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('group_questions', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->text(),
            'created_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'datetime NOT NULL',
        ]);

        /*$this->insert('group_questions', [
            'title' => 'test 1',
            'description' => 'content 1',
        ]);*/
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        echo "m171227_091608_group_questions cannot be reverted.\n";
        $this->dropTable('group_questions');
        return false;
    }




}
