<?php

use yii\db\Migration;


class m170515_071441_catalog_item_slug extends Migration
{
    public function up()
    {
        $this->addColumn('catalog_item', 'slug', $this->string(255)->notNull());
    }

    public function down()
    {
        $this->dropColumn('catalog_item', 'slug');
    }

}
