<?php

use yii\db\Migration;

/**
 * Class m180302_143521_vacancies
 */
class m180302_143521_vacancies extends Migration
{


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('vacancies', [
            'id' => $this->primaryKey(),
            'position' => $this->string(255),
            'descripton' => $this->text(),
            'city' => $this->string(255),
            'lang' => $this->string(2)->defaultValue("ru"),
            'sort' => $this->integer()->notNull()->defaultValue(0),
            'published' => $this->smallInteger(1)->defaultValue(0),
            'created_at' => $this->timestamp()->defaultValue(null),
            'updated_at' => 'timestamp on update current_timestamp',
        ]);
    }

    public function down()
    {
        echo "m180302_143521_vacancies cannot be reverted.\n";

        $this->dropTable('vacancies');
    }

}
