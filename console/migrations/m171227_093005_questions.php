<?php

use yii\db\Migration;

/**
 * Class m171227_093005_questions
 */
class m171227_093005_questions extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('questions', [
            'id' => $this->primaryKey(),
            'json_data' => $this->text(),
            'id_group' => $this->integer(),
            'created_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'datetime NOT NULL',
        ]);

        $this->addForeignKey(
            'fk-questions-id_group',
            'questions',
            'id_group',
            'group_questions',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        echo "m171227_093005_questions cannot be reverted.\n";
        $this->dropTable('questions');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171227_093005_questions cannot be reverted.\n";

        return false;
    }
    */
}
