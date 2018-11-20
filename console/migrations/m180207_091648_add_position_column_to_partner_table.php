<?php

use yii\db\Migration;

/**
 * Handles adding position to table `partner`.
 */
class m180207_091648_add_position_column_to_partner_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('partner', 'short_description', $this->text());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('partner', 'short_description');
    }
}
