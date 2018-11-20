<?php

use yii\db\Migration;


class m170614_080812_table_order extends Migration
{
    public function up()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(),
            'email' => $this->string(254)->notNull(),
            'first_name' => $this->string(32)->notNull(),
            'last_name' => $this->string(32)->notNull(),
            'phone' => $this->string(32)->notNull(),
            'comment' => $this->text(),
            'status' => $this->string(128)->notNull(),
            'total' => $this->decimal(15,4)->notNull(),
            'currency_code' => $this->char(3)->notNull()->defaultValue('UAH'),
            'currency_value' => $this->decimal(15,8)->notNull(),
            'ip' => $this->string(40)->notNull(),
            'forwarded_ip' => $this->string(40)->notNull(),
            'user_agent' => $this->string(255)->notNull(),
            'lang' => $this->char(2)->notNull()->defaultValue('ru'),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);
    }

    public function down()
    {
        $this->dropTable('order');
    }
}
