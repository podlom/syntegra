<?php

namespace common\models;


use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "partner".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $lang
 * @property integer $published
 * @property string $created_at
 * @property string $updated_at

 * @property integer $sort
 */
class PartnerCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partner_category';
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
            [[/* 'slug', */ 'title'], 'required'],
            [['published', 'sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['slug', 'title'], 'string', 'max' => 255],
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
            'slug' => Yii::t('app', 'Slug'),
            'title' => Yii::t('app', 'Title'),
            'lang' => Yii::t('app', 'Lang'),
            'published' => Yii::t('app', 'Published'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'logo_url' => Yii::t('app', 'Logo URL'),
            'sort' => Yii::t('app', 'Sort Order'),
        ];
    }
}
