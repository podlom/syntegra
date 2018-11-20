<?php

use yii\db\Migration;


class m170515_074032_catalog_item_image_sort_published extends Migration
{
    public function up()
    {
        $this->addColumn('catalog_item_image', 'sort', $this->smallInteger(1)->defaultValue(0));
        $this->addColumn('catalog_item_image', 'published', $this->integer()->notNull()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('catalog_item_image', 'sort');
        $this->dropColumn('catalog_item_image', 'published');
    }
}
