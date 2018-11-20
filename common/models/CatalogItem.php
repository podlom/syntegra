<?php

namespace common\models;


use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "catalog_item".
 *
 * @property integer $id
 * @property string $title
 * @property integer $category_id
 * @property string $descr
 * @property integer $published
 * @property string $created_at
 * @property string $updated_at
 * @property string $lang
 * @property integer $sort
 * @property string $price
 * @property string $sku
 * @property string $img_url
 * @property string $width
 * @property string $height
 * @property string $slug
 * @property integer $sub_category1_id
 * @property integer $sub_category2_id
 * @property integer $sub_category3_id
 * @property integer $sub_category4_id
 * @property string $description_short
 * @property integer $quantity
 * @property string $surface
 * @property string $weight
 * @property string $montage_way
 *
 * @property CatalogCategory $category
 * @property CatalogItemAttribute[] $catalogItemAttributes
 * @property CatalogItemImage[] $catalogItemImages
 * @property CatalogItemVideo[] $catalogItemVideos
 * @property CatalogItemVariant[] $catalogItemVariants
 */
class CatalogItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_item';
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
            // автоматическая генерация значения slug на основе title с использованием транслитерации
            'slug' => [
                'class' => 'common\behaviors\Slug',
                'in_attribute' => 'sku',
                'out_attribute' => 'slug',
                'translit' => true,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'sort'], 'required'],
            [['category_id', 'published', 'sort', 'quantity', 'sub_category1_id', 'sub_category2_id', 'sub_category3_id', 'sub_category4_id'], 'integer'],
            [['descr'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['price', 'width', 'height', 'weight'], 'number'],
            [['title', 'sku', 'img_url', 'slug', 'description_short'], 'string', 'max' => 255],
            [['surface', 'montage_way'], 'string', 'max' => 64],
            [['lang'], 'string', 'max' => 2],
            /*
            [['category_id'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            */
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'category_id' => Yii::t('app', 'Category ID'),
            'descr' => Yii::t('app', 'Descr'),
            'published' => Yii::t('app', 'Published'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'lang' => Yii::t('app', 'Lang'),
            'sort' => Yii::t('app', 'Sort'),
            'sku' => Yii::t('app', 'Sku'),
            'img_url' => Yii::t('app', 'Img Url'),
            'width' => Yii::t('app', 'Width, mm'),
            'height' => Yii::t('app', 'Height, mm'),
            'slug' => Yii::t('app', 'Slug'),
            'sub_category1_id' => Yii::t('app', 'Sub category #1'),
            'sub_category2_id' => Yii::t('app', 'Sub category #2'),
            'sub_category3_id' => Yii::t('app', 'Sub category #3'),
            'sub_category4_id' => Yii::t('app', 'Sub category #4'),
            'description_short' => Yii::t('app', 'Description short'),
            'quantity' => Yii::t('app', 'Quantity'),
            'surface' => Yii::t('app', 'Surface'),
            'weight' => Yii::t('app', 'Weight'),
            'montage_way' => Yii::t('app', 'Montage way'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasMany(CatalogCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogItemAttributes()
    {
        return $this->hasMany(CatalogItemAttribute::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogItemImages()
    {
        return $this->hasMany(CatalogItemImage::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogItemVariant()
    {
        return $this->hasMany(CatalogItemVariant::className(), ['product_id' => 'id']);
    }

    public function getDefaultCatalogItemVariant()
    {
        $catItemVariants = $this->getCatalogItemVariant()->asArray()->all();
        if (!empty($catItemVariants)) {
            foreach ($catItemVariants as $catItVar) {
                if ($catItVar['default'] == 1) {
                    // Yii::info('Found default item variant: ' . var_export($catItVar, 1));
                    return $catItVar;
                }
            }
        }
        return [];
    }

    public function getImage()
    {
        $cItVar = $this->getDefaultCatalogItemVariant();

        if (!empty($cItVar)) {
            return $cItVar['img_url'];
        } else {
            return '/images/product/product_big_1.jpg';
        }
    }

    public function getItemTitle()
    {
        $cItVar = $this->getDefaultCatalogItemVariant();

        if (!empty($cItVar)) {
            return $cItVar['title'];
        }
    }

    public function getItemPrice()
    {
        $cItVar = $this->getDefaultCatalogItemVariant();

        if (!empty($cItVar)) {
            // Yii::info('Default item variant: ' . var_export($cItVar, 1));
            return $cItVar['price'];
        } else {
            return 0.00;
        }
    }

    public function getItemDescr()
    {
        $cItVar = $this->getDefaultCatalogItemVariant();

        if (!empty($cItVar)) {
            return strip_tags($cItVar['descr'], '<a><p><div><span><strong><em><br>');
        }
    }

    public function getLength()
    {
        $itemVariant = $this->getCatalogItemVariant()->asArray()->all();

        if (!empty($itemVariant)) {
            return $itemVariant[0]['length'];
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogItemVideos()
    {
        return $this->hasMany(CatalogItemVideo::className(), ['item_id' => 'id']);
    }
}
