<?php

use yii\db\Migration;


class m170522_072157_catalog_item_variant_articuls extends Migration
{
    public function up()
    {
        $this->addColumn('catalog_item_variant', 'articul_1c', $this->string(64)->notNull());
        $this->addColumn('catalog_item_variant', 'articul_epicentr', $this->string(64)->notNull());
    }

    public function down()
    {
        $this->dropColumn('catalog_item_variant', 'articul_1c');
        $this->dropColumn('catalog_item_variant', 'articul_epicentr');
    }
}
