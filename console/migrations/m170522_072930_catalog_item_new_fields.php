<?php

use yii\db\Migration;


class m170522_072930_catalog_item_new_fields extends Migration
{
    public function up()
    {
        $this->addColumn('catalog_item', 'sub_category1_id', $this->integer()->notNull());
        $this->addColumn('catalog_item', 'sub_category2_id', $this->integer()->notNull());
        $this->addColumn('catalog_item', 'sub_category3_id', $this->integer()->notNull());
        $this->addColumn('catalog_item', 'sub_category4_id', $this->integer()->notNull());
        $this->addColumn('catalog_item', 'description_short', $this->string(255)->notNull());
        $this->addColumn('catalog_item', 'quantity', $this->smallInteger(1)->defaultValue(0));
        $this->addColumn('catalog_item', 'surface', $this->string(64)->notNull());
        $this->addColumn('catalog_item', 'weight', $this->decimal(19, 2)->notNull()->defaultValue(0.0));
        $this->addColumn('catalog_item', 'montage_way', $this->string(64)->notNull());
    }

    public function down()
    {
        $this->dropColumn('catalog_item', 'sub_category1_id');
        $this->dropColumn('catalog_item', 'sub_category2_id');
        $this->dropColumn('catalog_item', 'sub_category3_id');
        $this->dropColumn('catalog_item', 'sub_category4_id');
        $this->dropColumn('catalog_item', 'description_short');
        $this->dropColumn('catalog_item', 'quantity');
        $this->dropColumn('catalog_item', 'surface');
        $this->dropColumn('catalog_item', 'weight');
        $this->dropColumn('catalog_item', 'montage_way');
    }
}
