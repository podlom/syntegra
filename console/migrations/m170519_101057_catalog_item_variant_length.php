<?php

use yii\db\Migration;


class m170519_101057_catalog_item_variant_length extends Migration
{
    public function up()
    {
        $this->addColumn('catalog_item_variant', 'length', $this->decimal(19, 2)->notNull()->defaultValue(0.0));
    }

    public function down()
    {
        $this->dropColumn('catalog_item_variant', 'length');
    }
}
