<?php

namespace common\models;


use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "meta".
 *
 * @property integer $id
 * @property string $url
 * @property string $title
 * @property string $description
 * @property string $keywords
 * @property string $h1
 * @property string $seo
 * @property string $og_title
 * @property string $og_description
 * @property string $og_image
 * @property string $meta_image
 * @property integer $published
 * @property string $lang
 * @property string $created_at
 * @property string $updated_at
 */
class Meta extends ActiveRecord
{
    /**
     * Model's behavior
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => function () {return date('Y-m-d H:i:s');},
            ],
        ];
    }

    /**
     * Field names
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'URL',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'keywords' => 'Ключевые слова',
            'h1' => 'H1',
            'seo' => 'SEO текст',
            'og_title' => 'og:title',
            'og_description' => 'og:description',
            'og_image' => 'og:image',
            'meta_image' => 'meta image',
            'published' => 'Включено',
            'lang' => 'Language',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено'
        ];
    }

    /**
     * Find metadata by url
     * @param string $url
     * @return Meta the loaded model
     */
    public static function findOneByUrl($url, $lang = null)
    {
        if (is_null($lang)) {
            $lang = Yii::$app->language;
        }

        $meta = self::findOne([
            'url' => sprintf('/%s', $url),
            'lang' => Yii::$app->db->quoteSql($lang),
            'published' => 1,
        ]);

        if ($meta) {
            return $meta;
        }

        return self::getDefaultMetadata($lang);
    }

    public static function getDefaultMetadata($lang = null)
    {
        if (is_null($lang)) {
            $lang = Yii::$app->language;
        }

        $meta = new \stdClass();
        $meta->title = Yii::$app->settings->get('meta', 'title', 'Syntegra');
        $meta->description = Yii::$app->settings->get('meta', 'description', 'Syntegra');
        $meta->keywords = Yii::$app->settings->get('meta', 'keywords', 'Syntegra');
        $meta->h1 = Yii::$app->settings->get('meta', 'h1', 'Syntegra');
        $meta->seo = Yii::$app->settings->get('meta', 'seo', 'Syntegra');
        $meta->og_title = Yii::$app->settings->get('meta', 'og_title', 'Syntegra');
        $meta->og_description = Yii::$app->settings->get('meta', 'og_description', 'Syntegra');
        $meta->og_image = Yii::$app->settings->get('meta', 'og_image', '/images/logo-header.png');
        $meta->meta_image = Yii::$app->settings->get('meta', 'meta_image', '/images/logo-header.png');
        $meta->lang = $lang;

        return $meta;
    }
}
