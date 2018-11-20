<?php

namespace backend\models;


use Yii;
use yii\base\Model;
use common\models\Seometrics;


class SeometricsForm extends Model
{
    public $slug;
    public $value;
    public $published;
    public $host;

    private $model_id = 0;

    public function rules()
    {
        return [
            ['slug', 'required'],
            [
                'slug',
                'match',
                'pattern' => '/^[a-z_-]+$/',
                'message' => 'Допустимы только прописные латинские буквы и символы - и _'
            ],
            [['slug', 'host'], 'unique', 'targetClass' => '\common\models\Seometrics', 'targetAttribute' => ['slug', 'host'],'filter' => ['!=', 'id', $this->model_id]],
            [['value', 'host'], 'string'],
            ['published', 'integer'],
        ];
    }

    public function setFromModel(Seometrics $slider)
    {
        $this->model_id = $slider->id;
        $this->slug = $slider->slug;
        $this->value = $slider->value;
        $this->published = $slider->published;
        $this->host = $slider->host;
    }

    public function setToModel(Seometrics $slider)
    {
        $slider->slug = $this->slug;
        $slider->value = $this->value;
        $slider->published = $this->published;
        $slider->host = $this->host;
    }

    /**
     * Field names
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Слаг',
            'value' => 'Содержание',
            'published' => 'Включен',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
        ];
    }
}