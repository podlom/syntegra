<?php

use yii\db\Migration;

class m170512_080527_catalogue_item_fixed_fields extends Migration
{
    public function up()
    {
        $this->addColumn('catalog_item', 'sku', $this->string(255)->notNull()->defaultValue(''));
        $this->addColumn('catalog_item', 'img_url', $this->string(255)->notNull()->defaultValue(''));
        // $this->addColumn('catalog_item', 'length', $this->decimal(19, 2)->notNull()->defaultValue(0.0));
        $this->addColumn('catalog_item', 'width', $this->decimal(19, 2)->notNull()->defaultValue(0.0));
        $this->addColumn('catalog_item', 'height', $this->decimal(19, 2)->notNull()->defaultValue(0.0));
        // $this->addColumn('catalog_item', 'color_id', $this->integer()->notNull());
    }

    public function down()
    {
        $this->dropColumn('catalog_item', 'sku');
        $this->dropColumn('catalog_item', 'img_url');
        // $this->dropColumn('catalog_item', 'length');
        $this->dropColumn('catalog_item', 'width');
        $this->dropColumn('catalog_item', 'height');
        // $this->dropColumn('catalog_item', 'color_id');
    }
}
