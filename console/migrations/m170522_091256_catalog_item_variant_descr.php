<?php

use yii\db\Migration;


class m170522_091256_catalog_item_variant_descr extends Migration
{
    public function up()
    {
        $this->addColumn('catalog_item_variant', 'title', $this->string(255)->notNull());
        $this->addColumn('catalog_item_variant', 'descr', $this->string()->notNull());
        $this->addColumn('catalog_item_variant', 'description_short', $this->string(255)->notNull());
    }

    public function down()
    {
        $this->dropColumn('catalog_item_variant', 'title');
        $this->dropColumn('catalog_item_variant', 'descr');
        $this->dropColumn('catalog_item_variant', 'description_short');
    }
}
