<?php

use yii\db\Schema;
use yii\db\Migration;


class m170216_110314_meta extends Migration
{
    public function up()
    {
        $this->createTable('meta', [
            'id' => Schema::TYPE_PK,
            'url' => Schema::TYPE_STRING . '(255) NOT NULL',
            'description' => Schema::TYPE_TEXT . ' NOT NULL',
            'keywords' => Schema::TYPE_TEXT . ' DEFAULT NULL',
            'published' => Schema::TYPE_BOOLEAN . ' NOT NULL',
            'lang' => $this->char(2)->defaultValue("ru"),
            'created_at' => Schema::TYPE_DATETIME . ' NOT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NOT NULL',
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->createIndex('idx__url', 'meta', 'url', true);
        $this->createIndex('idx__published', 'meta', 'published');
        $this->createIndex('idx__meta_lang', 'meta', 'lang');

        $this->addColumn('meta', 'title', Schema::TYPE_STRING . '(255) DEFAULT NULL AFTER url');
        $this->addColumn('meta', 'h1', Schema::TYPE_STRING . '(255) DEFAULT NULL AFTER keywords');
        $this->addColumn('meta', 'seo', Schema::TYPE_TEXT . ' DEFAULT NULL AFTER h1');

        $this->alterColumn('meta', 'description', Schema::TYPE_TEXT . ' DEFAULT NULL');

        $this->addColumn('meta', 'og_title', Schema::TYPE_STRING . '(255) DEFAULT NULL AFTER seo');
        $this->addColumn('meta', 'og_description', Schema::TYPE_TEXT . ' DEFAULT NULL AFTER og_title');
        $this->addColumn('meta', 'og_image', Schema::TYPE_STRING . '(255) DEFAULT NULL AFTER og_description');
        $this->addColumn('meta', 'meta_image', Schema::TYPE_STRING . '(255) DEFAULT NULL AFTER og_image');
    }

    public function down()
    {
        $this->dropTable('meta');
    }
}
