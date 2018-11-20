<?php

use yii\db\Migration;

class m170307_143345_admin_groups_users extends Migration
{
    public function up()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        $dbType = $this->db->driverName;
        $tableOptions_mysql = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        /* MYSQL */
        if (!in_array('admin_group', $tables))  { 
            if ($dbType == "mysql") {
                $this->createTable('{{%admin_group}}', [
                    'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                    0 => 'PRIMARY KEY (`id`)',
                    'name' => 'VARCHAR(50) NULL',
                ], $tableOptions_mysql);

                $this->createTable('{{%admin_user_group}}', [
                    'user_id' => 'INT(11) NOT NULL',
                    'group_id' => 'INT(11) NOT NULL',
                ], $tableOptions_mysql);

                $this->createIndex('idx_group_id_8264_00', 'admin_user_group', 'group_id', 0);
                $this->createIndex('idx_user_id_8264_01', 'admin_user_group', 'user_id', 0);

                $this->execute('SET foreign_key_checks = 0');
                $this->addForeignKey('fk_group_8254_00','{{%admin_user_group}}', 'group_id', '{{%admin_group}}', 'id', 'CASCADE', 'CASCADE' );
                $this->addForeignKey('fk_user_8254_01','{{%admin_user_group}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE' );
                $this->execute('SET foreign_key_checks = 1;');
            }
        }
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `admin_group`');
        $this->execute('DROP TABLE IF EXISTS `admin_user_group`');
        $this->execute('SET foreign_key_checks = 1;');
    }
}
