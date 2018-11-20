<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "video_consultant".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $lang
 * @property string $title
 * @property string $img_url
 * @property string $video_url
 * @property string $short_descr
 * @property integer $published
 * @property integer $sort
 * @property string $created_at
 * @property string $updated_at
 */
class VideoConsultant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'video_consultant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'published', 'sort'], 'integer'],
            [['title'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['lang'], 'string', 'max' => 2],
            [['title'], 'string', 'max' => 128],
            [['img_url', 'video_url', 'short_descr'], 'string', 'max' => 255],
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
            'lang' => Yii::t('app', 'Lang'),
            'title' => Yii::t('app', 'Title'),
            'img_url' => Yii::t('app', 'Img Url'),
            'video_url' => Yii::t('app', 'Video Url'),
            'short_descr' => Yii::t('app', 'Short Descr'),
            'published' => Yii::t('app', 'Published'),
            'sort' => Yii::t('app', 'Sort'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
