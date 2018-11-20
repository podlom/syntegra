<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "catalog_item_attribute".
 *
 * @property integer $id
 * @property integer $item_id
 * @property string $name
 * @property string $lang
 * @property integer $published
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CatalogItem $item
 */
class CatalogItemAttribute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_item_attribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id'], 'required'],
            [['item_id', 'published'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['lang'], 'string', 'max' => 2],
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
            'name' => Yii::t('app', 'Name'),
            'lang' => Yii::t('app', 'Lang'),
            'published' => Yii::t('app', 'Published'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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
