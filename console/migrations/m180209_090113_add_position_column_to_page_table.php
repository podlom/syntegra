<?php

use yii\db\Migration;

/**
 * Handles adding position to table `page`.
 */
class m180209_090113_add_position_column_to_page_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('page', 'img_url', $this->string(255));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('page', 'img_url');
    }
}
