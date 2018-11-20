<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "seo_metrics".
 *
 * @property integer $id
 * @property string  $slug
 * @property string  $value
 * @property integer $published
 * @property string  $created_at
 * @property string  $updated_at
 * @property string  $host
 */
class Seometrics extends ActiveRecord
{
    /**
     * Название таблицы
     * @return string
     */
    public static function tableName()
    {
        return 'seo_metrics';
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
     * Return value by slug
     * @return array
     */
    public static function getValueBySlug($slug)
    {
        return static::find()
            ->select('value')
            ->where([
                'slug' => $slug,
                'published' => 1,
            ])
            ->andWhere([
                'or',
                ['host' => $_SERVER['HTTP_HOST']],
                ['host' => ''],
            ])
            ->orderBy(['host' => SORT_DESC])
            ->limit(1)
            ->scalar();
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
