<?php

namespace common\models;


use Yii;
use yii\db\ActiveRecord;
use backend\helpers\CatalogItemHelper;


/**
 * This is the model class for table "catalog_item_image".
 *
 * @property integer $id
 * @property integer $item_id
 * @property string $img_url
 * @property integer $sort
 * @property integer $published
 *
 * @property CatalogItem $item
 */
class CatalogItemImage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_item_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'img_url'], 'required'],
            [['item_id', 'sort', 'published'], 'integer'],
            [['img_url'], 'string', 'max' => 255],
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
            'img_url' => Yii::t('app', 'Img Url'),
            'sort' => Yii::t('app', 'Sort'),
            'published' => Yii::t('app', 'Published'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(CatalogItem::className(), ['id' => 'item_id']);
    }

    public function getProductTitle($id = null)
    {
        if (is_null($id)) {
            $id = $this->id;
        }
        return CatalogItemHelper::getProductTitleById($id);
    }
}
