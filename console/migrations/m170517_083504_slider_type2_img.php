<?php

use yii\db\Migration;


class m170517_083504_slider_type2_img extends Migration
{
    public function up()
    {
        $this->addColumn('slide', 'img_url2', $this->string(255)->notNull()->defaultValue(''));
    }

    public function down()
    {
        $this->dropColumn('slide', 'img_url2');
    }
}
