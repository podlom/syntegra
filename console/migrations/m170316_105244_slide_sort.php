<?php

use yii\db\Migration;

class m170316_105244_slide_sort extends Migration
{
    public function up()
    {
        $this->addColumn('slide', 'sort', $this->integer()->notNull()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('slide', 'sort');
    }
}
