<?php

use yii\db\Migration;

class m170316_102054_partner_sort extends Migration
{
    public function up()
    {
        $this->addColumn('partner', 'sort', $this->integer()->notNull()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('partner', 'sort');
    }
}
