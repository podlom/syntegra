<?php

use yii\db\Migration;


class m170522_083531_catalog_item_variant_subcategories extends Migration
{
    public function up()
    {
        $this->addColumn('catalog_item_variant', 'sub_category1_id', $this->integer()->notNull());
        $this->addColumn('catalog_item_variant', 'sub_category2_id', $this->integer()->notNull());
        $this->addColumn('catalog_item_variant', 'sub_category3_id', $this->integer()->notNull());
        $this->addColumn('catalog_item_variant', 'sub_category4_id', $this->integer()->notNull());
    }

    public function down()
    {
        $this->dropColumn('catalog_item_variant', 'sub_category1_id');
        $this->dropColumn('catalog_item_variant', 'sub_category2_id');
        $this->dropColumn('catalog_item_variant', 'sub_category3_id');
        $this->dropColumn('catalog_item_variant', 'sub_category4_id');
    }
}
