<?php

namespace common\models;


use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "slide".
 *
 * @property integer $id
 * @property string $title
 * @property string $img_url
 * @property string $lang
 * @property integer $published
 * @property string $created_at
 * @property string $updated_at
 * @property integer $sort
 * @property integer $category_id
 * @property string $text
 * @property string $img_url2
 * @property string $href
 */
class Slide extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slide';
    }

    /**
     * Поведения модели
     * @return array
     */
    public function behaviors()
    {
        return [
            // автозаполнение полей created_at и updated_at
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => function () {return date('Y-m-d H:i:s');},
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'img_url'], 'required'],
            [['published', 'sort', 'category_id'], 'integer'],
            [['published', 'sort', 'category_id', 'created_at', 'updated_at'], 'safe'],
            [['text'], 'string'],
            [['title', 'img_url', 'img_url2', 'href'], 'string', 'max' => 255],
            [['lang'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'img_url' => Yii::t('app', 'Img Url'),
            'img_url2' => Yii::t('app', 'Img Url2'),
            'lang' => Yii::t('app', 'Lang'),
            'published' => Yii::t('app', 'Published'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'sort' => Yii::t('app', 'Sort Order'),
            'category_id' => Yii::t('app', 'Category'),
            'text' => Yii::t('app', 'Slide Text'),
            'href' => Yii::t('app', 'Href URL'),
        ];
    }
}
