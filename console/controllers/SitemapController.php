<?php
namespace console\controllers;


use yii\console\Controller;
use yii\helpers\Url;


/**
 * Sitemap console commands
 */
class SitemapController extends Controller
{

    private $templateName = 'syntegra';
    
    /**
     * Create/update Sitemap template file
     */
    public function actionGenerate()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8" ?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

        $models = [
            'common\models\Page' => [
                'path' => 'page/',
                'urladd' => '',
            ],
            'common\models\News' => [
                'path' => 'news/',
                'urladd' => '',
            ],
        ];

        foreach ($models as $model => $options) {
            $items = $model::find()
                           ->where(['published' => 1])
                           ->asArray()
                           ->all();

            foreach ($items as $item) {
                if (isset($item['slug']) && isset($item['lang']) && isset($item['updated_at'])) {
                    $langUri = $item['lang'] . '/';
                    $sitemap .= "\n<url>\n\t<loc>{host}" . $langUri . $options['path'] . $item['slug'] . $options['urladd'] .
                        "</loc>\n\t<lastmod>" . substr($item['updated_at'], 0, 10) . "</lastmod>\n</url>";
                }
            }
        }

        $sitemap .= "\n</urlset>";

        $file = fopen(\Yii::getAlias('@frontend').'/web/sitemap/' . $this->templateName . '.tpl', 'w+');
        fwrite($file, $sitemap);
        fclose($file);

        $this->stdout("Sitemap template was generated\n");
    }
}
