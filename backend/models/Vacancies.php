<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "vacancies".
 *
 * @property int $id
 * @property string $position
 * @property string $descripton
 * @property string $city
 * @property string $lang
 * @property int $sort
 * @property int $published
 * @property string $created_at
 * @property string $updated_at
 */
class Vacancies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vacancies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripton'], 'string'],
            [['sort', 'published'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['position', 'city'], 'string', 'max' => 255],
            [['lang'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'position' => 'Position',
            'descripton' => 'Descripton',
            'city' => 'City',
            'lang' => 'Lang',
            'sort' => 'Sort',
            'published' => 'Published',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
