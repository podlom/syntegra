<?php

use yii\db\Migration;

/**
 * Handles adding position to table `partner`.
 */
class m180209_090141_add_position_column_to_partner_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('partner', 'title1', $this->string(255));
        $this->addColumn('partner', 'block1', $this->text());
        $this->addColumn('partner', 'title2', $this->string(255));
        $this->addColumn('partner', 'block2', $this->text());
        $this->addColumn('partner', 'title3', $this->string(255));
        $this->addColumn('partner', 'block3', $this->text());

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('partner', 'title1');
        $this->dropColumn('partner', 'block1');
        $this->dropColumn('partner', 'title2');
        $this->dropColumn('partner', 'block2');
        $this->dropColumn('partner', 'title3');
        $this->dropColumn('partner', 'block3');
    }
}
