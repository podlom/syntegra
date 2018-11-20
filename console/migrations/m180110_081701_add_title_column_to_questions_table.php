<?php

use yii\db\Migration;

/**
 * Handles adding title to table `questions`.
 */
class m180110_081701_add_title_column_to_questions_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('questions', 'title', $this->string(100));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('questions', 'title');
    }
}
