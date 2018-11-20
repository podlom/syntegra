<?php

use yii\db\Migration;


class m170522_120819_catalog_item_variant_price extends Migration
{
    public function up()
    {
        $this->addColumn('catalog_item_variant', 'price', $this->decimal(19, 2)->notNull()->defaultValue(0.0));
    }

    public function down()
    {
        $this->dropColumn('catalog_item_variant', 'price');
    }
}
