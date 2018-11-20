<?php

namespace backend\models;


use Yii;
use yii\base\Model;
use common\models\Meta;


class MetaForm extends Model
{
    public $url;
    public $title;
    public $description;
    public $keywords;
    public $h1;
    public $seo;
    public $og_title;
    public $og_description;
    public $og_image;
    public $meta_image;
    public $lang;
    public $published;

    public $model_id = 0;

    public function rules()
    {
        return [
            [['url'], 'required'],
            [
                [
                    'url',
                    'title',
                    'description',
                    'keywords',
                    'h1',
                    'seo',
                    'og_title',
                    'og_description',
                    'og_image',
                    'meta_image',
                    'lang',
                ],
                'trim'
            ],
            ['url', 'unique', 'targetClass' => '\common\models\Meta', 'filter' => ['!=', 'id', $this->model_id]],
            ['published', 'integer'],
        ];
    }

    public function setFromModel(Meta $meta)
    {
        $this->model_id = $meta->id;
        $this->url = $meta->url;
        $this->title = $meta->title;
        $this->description = $meta->description;
        $this->keywords = $meta->keywords;
        $this->h1 = $meta->h1;
        $this->seo = $meta->seo;
        $this->og_title = $meta->og_title;
        $this->og_description = $meta->og_description;
        $this->og_image = $meta->og_image;
        $this->meta_image = $meta->meta_image;
        $this->lang = $meta->lang;
        $this->published = $meta->published;
    }

    public function setToModel(Meta $meta)
    {
        $meta->url = $this->url;
        $meta->title = $this->title ?: null;
        $meta->description = $this->description ?: null;
        $meta->keywords = $this->keywords ?: null;
        $meta->h1 = $this->h1 ?: null;
        $meta->seo = $this->seo ?: null;
        $meta->og_title = $this->og_title ?: null;
        $meta->og_description = $this->og_description ?: null;
        $meta->og_image = $this->og_image ?: null;
        $meta->meta_image = $this->meta_image ?: null;
        $meta->lang = $this->lang;
        $meta->published = $this->published;
    }

    /**
     * Field names
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'url' => 'URL',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'keywords' => 'Ключевые слова',
            'h1' => 'H1',
            'seo' => 'SEO текст',
            'og_title' => 'og:title',
            'og_description' => 'og:description',
            'og_image' => 'og:image',
            'meta_image' => 'Meta image',
            'lang' => 'Language',
            'published' => 'Включено'
        ];
    }
}