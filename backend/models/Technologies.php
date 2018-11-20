<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "technologies".
 *
 * @property int $id
 * @property string $img
 * @property string $title
 * @property string $slug
 * @property string $lang
 * @property int $sort
 * @property int $published
 */
class Technologies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'technologies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'published'], 'integer'],
            [['img', 'title', 'slug'], 'string', 'max' => 255],
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
            'img' => 'Img',
            'title' => 'Title',
            'slug' => 'Slug',
            'lang' => 'Lang',
            'sort' => 'Sort',
            'published' => 'Published',
        ];
    }
}
