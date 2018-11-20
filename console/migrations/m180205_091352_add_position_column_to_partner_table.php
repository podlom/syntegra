<?php

use yii\db\Migration;

/**
 * Handles adding position to table `partner`.
 */
class m180205_091352_add_position_column_to_partner_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('partner', 'category_id', $this->integer());
        $this->addColumn('partner', 'description', $this->text());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('partner', 'category_id');
        $this->dropColumn('partner', 'description');
    }
}
