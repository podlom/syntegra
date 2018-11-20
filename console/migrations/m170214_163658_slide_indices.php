<?php

use yii\db\Migration;

class m170214_163658_slide_indices extends Migration
{
    public function up()
    {
        $this->createIndex('idx__slide_lang', 'slide', 'lang');
        $this->createIndex('idx__slide_published', 'slide', 'published');
    }

    public function down()
    {
        $this->dropIndex('idx__slide_lang', 'slide');
        $this->dropIndex('idx__slide_published', 'slide');
    }
}
