<?php

namespace common\models;


use Yii;
use yii\behaviors\TimestampBehavior;
use common\helpers\PageCategoryHelper;


/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $announce
 * @property string $body
 * @property string $lang
 * @property integer $published
 * @property string $created_at
 * @property string $updated_at
 * @property integer $sort
 * @property string $category_id
 * @property integer $question_id
 * @property integer $title1
 * @property integer $body1
    * @property integer $title2
 * @property integer $body2
 * @property integer $title3
 * @property integer $body3
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
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
            // автоматическая генерация значения slug на основе title с использованием транслитерации
           /* 'slug' => [
                'class' => 'common\behaviors\Slug',
                'in_attribute' => 'title',
                'out_attribute' => 'slug',
                'translit' => true,
            ]*/
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[/* 'slug', 'announce', */ 'title', 'body'], 'required'],
            [['announce', 'body','title1', 'body1','title2', 'body2','title3', 'body3'], 'string'],
            [['category_id', 'published', 'sort','question_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['slug', 'title', 'img_url'], 'string', 'max' => 255],
            [['lang'], 'string', 'max' => 2],
            [['category_id'], 'default', 'value' => 0],
            [['slug', 'lang'], 'unique', 'targetAttribute' => ['slug', 'lang']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'slug' => Yii::t('app', 'Slug'),
            'title' => Yii::t('app', 'Title'),
            'announce' => Yii::t('app', 'Announce'),
            'body' => Yii::t('app', 'Body'),
            'lang' => Yii::t('app', 'Lang'),
            'published' => Yii::t('app', 'Published'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'sort' => Yii::t('app', 'Sort Order'),
            'img_url' => Yii::t('app', 'Image Url'),
            'question_id' => Yii::t('app', 'Question Form'),
            'title1'=>Yii::t('app', 'Title1'),
            'body1'=>Yii::t('app', 'Body1'),
            'title2'=>Yii::t('app', 'Title2'),
            'body2'=>Yii::t('app', 'Body2'),
            'title3'=>Yii::t('app', 'Title3'),
            'body3'=>Yii::t('app', 'Body3'),
        ];
    }

    public function getCategoryTitle()
    {
        return PageCategoryHelper::getCategoryTitleById($this->category_id);
    }
}
