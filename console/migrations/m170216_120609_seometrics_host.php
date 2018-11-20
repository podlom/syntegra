<?php

use yii\db\Schema;
use yii\db\Migration;


class m170216_120609_seometrics_host extends Migration
{
    public function up()
    {
        $this->addColumn(\common\models\Seometrics::tableName(), 'host', Schema::TYPE_STRING . ' COLLATE utf8_unicode_ci DEFAULT ""');
    }

    public function down()
    {
        $this->dropColumn(\common\models\Seometrics::tableName(), 'host');
    }
}
