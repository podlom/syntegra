<?php

namespace common\models;


use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "block".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $slug
 * @property string $lang
 * @property string $title
 * @property string $body
 * @property integer $sort
 * @property integer $published
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CatalogCategory $category
 */
class Block extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'block';
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
            'slug' => [
                'class' => 'common\behaviors\Slug',
                'in_attribute' => 'title',
                'out_attribute' => 'slug',
                'translit' => true,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'sort', 'published'], 'integer'],
            [[/* 'slug', */ 'title', 'body'], 'required'],
            [['body'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['slug', 'title'], 'string', 'max' => 255],
            [['lang'], 'string', 'max' => 2],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['category_id'], 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'slug' => Yii::t('app', 'Slug'),
            'lang' => Yii::t('app', 'Lang'),
            'title' => Yii::t('app', 'Title'),
            'body' => Yii::t('app', 'Body'),
            'sort' => Yii::t('app', 'Sort'),
            'published' => Yii::t('app', 'Published'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(CatalogCategory::className(), ['id' => 'category_id']);
    }
}
