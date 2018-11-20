<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property string $fullname
 * @property string $work_place
 * @property string $descripton
 * @property string $lang
 * @property int $sort
 * @property int $published
 * @property string $created_at
 * @property string $updated_at
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reviews';
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
            [['fullname', 'work_place'], 'string', 'max' => 255],
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
            'fullname' => 'Fullname',
            'work_place' => 'Work Place',
            'descripton' => 'Descripton',
            'lang' => 'Lang',
            'sort' => 'Sort',
            'published' => 'Published',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
