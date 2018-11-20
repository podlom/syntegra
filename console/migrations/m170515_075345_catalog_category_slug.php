<?php

use yii\db\Migration;


class m170515_075345_catalog_category_slug extends Migration
{
    public function up()
    {
        $this->addColumn('catalog_category', 'slug', $this->string(255)->notNull());
    }

    public function down()
    {
        $this->dropColumn('catalog_category', 'slug');
    }
}
