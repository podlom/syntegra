<?php

use yii\db\Migration;

class m170215_103438_partner_logo extends Migration
{
    public function up()
    {
        $this->addColumn('partner', 'logo_url', $this->string(255)->notNull()->defaultValue(''));
    }

    public function down()
    {
        $this->dropColumn('partner', 'logo_url');
    }
}
