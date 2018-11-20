<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "team".
 *
 * @property int $id
 * @property string $position
 * @property string $img
 * @property string $fullname
 * @property string $descripton
 * @property string $lang
 * @property int $sort
 * @property int $published
 */
class Team extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'team';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripton'], 'string'],
            [['sort', 'published'], 'integer'],
            [['position', 'img', 'fullname'], 'string', 'max' => 255],
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
            'img' => 'Img',
            'fullname' => 'Fullname',
            'descripton' => 'Descripton',
            'lang' => 'Lang',
            'sort' => 'Sort',
            'published' => 'Published',
        ];
    }
}
