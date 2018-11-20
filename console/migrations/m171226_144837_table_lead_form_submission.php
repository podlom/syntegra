<?php

use yii\db\Migration;


/**
 * Class m171226_144837_table_lead_form_submission
 */
class m171226_144837_table_lead_form_submission extends Migration
{
    public function up()
    {
        $this->createTable('lead_form_submission', [
            'id' => $this->primaryKey(),
            'lead_form_id' => $this->integer()->notNull()->defaultValue(0),
            'user_id' => $this->integer()->notNull()->defaultValue(0),
            'form_data' => $this->text()->notNull(),
            'server' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->defaultValue(null),
            'updated_at' => 'timestamp on update current_timestamp',
        ], 'ENGINE = INNODB AUTO_INCREMENT = 1 CHARACTER SET utf8 COLLATE utf8_unicode_ci');
    }

    public function down()
    {
        $this->dropTable('lead_form_submission');
    }
}
