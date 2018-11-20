<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "catalog_item_video".
 *
 * @property integer $id
 * @property integer $item_id
 * @property string $video_url
 *
 * @property CatalogItem $item
 */
class CatalogItemVideo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_item_video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'video_url'], 'required'],
            [['item_id'], 'integer'],
            [['video_url'], 'string', 'max' => 255],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogItem::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'item_id' => Yii::t('app', 'Item ID'),
            'video_url' => Yii::t('app', 'Video Url'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(CatalogItem::className(), ['id' => 'item_id']);
    }
}
