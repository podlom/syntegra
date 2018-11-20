<?php

use yii\db\Migration;

class m170328_141432_slide_text extends Migration
{
    public function up()
    {
        $this->addColumn('slide', 'text', $this->text()->notNull());
    }

    public function down()
    {
        $this->dropColumn('slide', 'text');
    }
}
