<?php

use yii\db\Migration;

class m170328_133032_slide_category extends Migration
{
    public function up()
    {
        $this->addColumn('slide', 'category_id', $this->integer()->notNull());
        $this->createIndex('idx__slide_category_id', 'slide', 'category_id');
    }

    public function down()
    {
        $this->dropIndex('idx__slide_category_id', 'slide');
        $this->dropColumn('slide', 'category_id');
    }
}
