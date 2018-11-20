<?php

use yii\db\Migration;

class m170307_172406_catalogue extends Migration
{
    public function up()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        $dbType = $this->db->driverName;
        $tableOptions_mysql = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        $tableOptions_mssql = "";
        $tableOptions_pgsql = "";
        $tableOptions_sqlite = "";
        /* MYSQL */
        if ($dbType == "mysql") {
            if (!in_array('catalog_item', $tables))  { 
                $this->createTable('{{%catalog_item}}', [
                    'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                    0 => 'PRIMARY KEY (`id`)',
                    'title' => 'VARCHAR(255) NULL',
                    'category_id' => 'INT(11) NOT NULL',
                    'descr' => 'TEXT NULL',
                    'published' => 'TINYINT(1) NOT NULL DEFAULT \'1\'',
                    'created_at' => 'DATETIME NULL',
                    'updated_at' => 'DATETIME NULL',
                    'lang' => 'CHAR(2) NOT NULL DEFAULT \'ru\'',
                    'sort' => 'INT(11) NOT NULL',
                    'price' => 'DECIMAL(19,2) NULL',
                ], $tableOptions_mysql);
            }

            if (!in_array('catalog_category_relation', $tables))  { 
                $this->createTable('{{%catalog_category_relation}}', [
                    'id1' => 'INT(11) NOT NULL',
                    'id2' => 'INT(11) NOT NULL',
                    'added_at' => 'DATETIME NULL',
                    'updated_at' => 'DATETIME NULL',
                    4 => 'PRIMARY KEY (`id1`, `id2`)',
                ], $tableOptions_mysql);
            }

            if (!in_array('catalog_category', $tables))  { 
                $this->createTable('{{%catalog_category}}', [
                    'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                    0 => 'PRIMARY KEY (`id`)',
                    'name' => 'VARCHAR(50) NULL',
                    'img_url' => 'VARCHAR(255) NULL',
                    'published' => 'TINYINT(1) NOT NULL DEFAULT \'1\'',
                    'lang' => 'CHAR(2) NOT NULL DEFAULT \'ru\'',
                    'created_at' => 'DATETIME NULL',
                    'updated_at' => 'DATETIME NULL',
                    'sort' => 'INT(11) NOT NULL',
                    'descr' => 'TEXT NULL',
                ], $tableOptions_mysql);
            }

            if (!in_array('catalog_item_attribute', $tables))  { 
                $this->createTable('{{%catalog_item_attribute}}', [
                    'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                    0 => 'PRIMARY KEY (`id`)',
                    'item_id' => 'INT(11) NOT NULL',
                    'name' => 'VARCHAR(50) NULL',
                    'lang' => 'CHAR(2) NOT NULL DEFAULT \'ru\'',
                    'published' => 'TINYINT(1) NOT NULL DEFAULT \'1\'',
                    'created_at' => 'DATETIME NULL',
                    'updated_at' => 'DATETIME NULL',
                ], $tableOptions_mysql);
            }

            if (!in_array('catalog_item_image', $tables))  { 
                $this->createTable('{{%catalog_item_image}}', [
                    'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                    0 => 'PRIMARY KEY (`id`)',
                    'item_id' => 'INT(11) NOT NULL',
                    'img_url' => 'VARCHAR(255) NULL',
                ], $tableOptions_mysql);
            }

            if (!in_array('catalog_item_video', $tables))  { 
                $this->createTable('{{%catalog_item_video}}', [
                    'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                    0 => 'PRIMARY KEY (`id`)',
                    'item_id' => 'INT(11) NOT NULL',
                    'video_url' => 'VARCHAR(255) NOT NULL',
                ], $tableOptions_mysql);
            }

            // $this->createIndex('idx_UNIQUE_category_id_6672_00','catalog_item','category_id', 1);
            $this->createIndex('idx_category_id_6672_01','catalog_item','category_id', 0);
            $this->createIndex('idx_lang_6672_02','catalog_item','lang', 0);
            $this->createIndex('idx_published_6672_03','catalog_item','published', 0);
            $this->createIndex('idx_UNIQUE_id1_6882_04','catalog_category_relation','id1', 1);
            $this->createIndex('idx_id1_6882_05','catalog_category_relation','id1', 0);
            $this->createIndex('idx_id2_6882_06','catalog_category_relation','id2', 0);
            $this->createIndex('idx_lang_7282_07','catalog_category','lang', 0);
            $this->createIndex('idx_published_7282_08','catalog_category','published', 0);
            $this->createIndex('idx_item_id_7412_09','catalog_item_attribute','item_id', 0);
            $this->createIndex('idx_item_id_7552_10','catalog_item_image','item_id', 0);
            $this->createIndex('idx_item_id_7852_11','catalog_item_video','item_id', 0);
             
            $this->execute('SET foreign_key_checks = 0');
            $this->addForeignKey('fk_catalog_category_6882_00','{{%catalog_category_relation}}', 'id1', '{{%catalog_category}}', 'id', 'CASCADE', 'CASCADE' );
            $this->addForeignKey('fk_catalog_category_6882_01','{{%catalog_category_relation}}', 'id2', '{{%catalog_category}}', 'id', 'CASCADE', 'CASCADE' );
            // $this->addForeignKey('fk_catalog_item_7272_02','{{%catalog_category}}', 'id', '{{%catalog_item}}', 'category_id', 'CASCADE', 'CASCADE' );
            $this->addForeignKey('fk_catalog_item_7272_02','{{%catalog_item}}', 'category_id', '{{%catalog_category}}', 'id', 'CASCADE', 'CASCADE' );
            $this->addForeignKey('fk_catalog_item_7402_03','{{%catalog_item_attribute}}', 'item_id', '{{%catalog_item}}', 'id', 'CASCADE', 'CASCADE' );
            $this->addForeignKey('fk_catalog_item_7542_04','{{%catalog_item_image}}', 'item_id', '{{%catalog_item}}', 'id', 'CASCADE', 'CASCADE' );
            $this->addForeignKey('fk_catalog_item_7852_05','{{%catalog_item_video}}', 'item_id', '{{%catalog_item}}', 'id', 'CASCADE', 'CASCADE' );
            $this->execute('SET foreign_key_checks = 1;');
        }
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `catalog_item`');
        $this->execute('DROP TABLE IF EXISTS `catalog_category_relation`');
        $this->execute('DROP TABLE IF EXISTS `catalog_category`');
        $this->execute('DROP TABLE IF EXISTS `catalog_item_attribute`');
        $this->execute('DROP TABLE IF EXISTS `catalog_item_image`');
        $this->execute('DROP TABLE IF EXISTS `catalog_item_video`');
        $this->execute('SET foreign_key_checks = 1;');
    }
}
