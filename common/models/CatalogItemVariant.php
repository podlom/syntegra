<?php

namespace common\models;


use Yii;


/**
 * This is the model class for table "catalog_item_variant".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $default
 * @property string $articul
 * @property integer $color_id
 * @property string $img_url
 * @property integer $sort
 * @property integer $published
 * @property string $created_at
 * @property string $updated_at
 * @property string $length
 * @property string $articul_1c
 * @property string $articul_epicentr
 * @property integer $sub_category1_id
 * @property integer $sub_category2_id
 * @property integer $sub_category3_id
 * @property integer $sub_category4_id
 * @property string $title
 * @property string $descr
 * @property string $description_short
 * @property string $price
 */
class CatalogItemVariant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_item_variant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'articul', 'img_url', 'sort'], 'required'],
            [['product_id', 'default', 'color_id', 'sort', 'published', 'sub_category1_id', 'sub_category2_id', 'sub_category3_id', 'sub_category4_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['descr', 'description_short'], 'string'],
            [['articul', 'img_url', 'title'], 'string', 'max' => 255],
            [['articul_1c', 'articul_epicentr'], 'string', 'max' => 64],
            [['length', 'price'], 'number'],
            [['sub_category1_id', 'sub_category2_id', 'sub_category3_id', 'sub_category4_id'], 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'default' => Yii::t('app', 'Default'),
            'articul' => Yii::t('app', 'Articul'),
            'color_id' => Yii::t('app', 'Color ID'),
            'img_url' => Yii::t('app', 'Img Url'),
            'sort' => Yii::t('app', 'Sort'),
            'published' => Yii::t('app', 'Published'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'length' => Yii::t('app', 'Length'),
            'articul_1c' => Yii::t('app', 'Articul 1C'),
            'articul_epicentr' => Yii::t('app', 'Articul Epicentr'),
            'price' => Yii::t('app', 'Price'),
        ];
    }
}
