<?php

use yii\db\Migration;


class m170522_092136_catalog_item_variant_lang extends Migration
{
    public function up()
    {
        $this->addColumn('catalog_item_variant', 'lang', $this->char(2)->notNull()->defaultValue('ru'));
    }

    public function down()
    {
        $this->dropColumn('catalog_item_variant', 'lang');
    }
}
