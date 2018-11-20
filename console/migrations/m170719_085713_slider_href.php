<?php

use yii\db\Migration;


class m170719_085713_slider_href extends Migration
{
    public function up()
    {
        $this->addColumn('slide', 'href', $this->string(255)->notNull());
    }

    public function down()
    {
        $this->dropColumn('slide', 'href');
    }
}
