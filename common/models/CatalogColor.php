<?php

namespace common\models;


use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "catalog_color".
 *
 * @property integer $id
 * @property string $title
 * @property string $lang
 * @property integer $published
 * @property string $created_at
 * @property string $updated_at
 */
class CatalogColor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_color';
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
            [['title'], 'required'],
            [['published'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
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
            'lang' => Yii::t('app', 'Lang'),
            'published' => Yii::t('app', 'Published'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
