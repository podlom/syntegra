<?php

use yii\db\Migration;


class m171220_104056_catalog_item_variant_descr_upd extends Migration
{
    public function up()
    {
        $this->alterColumn('catalog_item_variant', 'descr', $this->text()->notNull());
        $this->alterColumn('catalog_item_variant', 'description_short', $this->text()->notNull());
    }

    public function down()
    {
        $this->alterColumn('catalog_item_variant', 'descr', $this->string(255)->notNull());
        $this->alterColumn('catalog_item_variant', 'description_short', $this->string(255)->notNull());
    }
}
