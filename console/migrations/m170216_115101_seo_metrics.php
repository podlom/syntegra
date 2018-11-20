<?php

use yii\db\Schema;
use yii\db\Migration;

class m170216_115101_seo_metrics extends Migration
{
    private $footer = [
        'slug' => 'seo_metrics',
        'published' => 1,
    ];

    private $meta = [
        'slug' => 'meta_tags',
        'value' => '<meta name=\'generator\' content=\'WD&SS CMS\' />',
        'published' => 1,
    ];

    public function up()
    {
        $this->execute("
            CREATE TABLE seo_metrics (
              id int(11) NOT NULL AUTO_INCREMENT,
              slug varchar(255) DEFAULT NULL,
              value text,
              published tinyint(1) DEFAULT 0,
              created_at datetime DEFAULT NULL,
              updated_at datetime DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
        ");

        $now = date('Y-m-d H:i:s');
        $this->insert('seo_metrics', array_merge($this->footer, [
            'created_at' => $now,
            'updated_at' => $now
        ]));

        $this->insert('seo_metrics', array_merge($this->meta, [
            'created_at' => $now,
            'updated_at' => $now
        ]));
    }

    public function down()
    {
        $this->execute("
            DROP TABLE IF EXISTS seo_metrics;
        ");

        return true;
    }
}
