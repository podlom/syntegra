<?php

namespace common\models;


use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "catalog_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $img_url
 * @property integer $published
 * @property string $lang
 * @property string $created_at
 * @property string $updated_at
 * @property integer $sort
 * @property string $descr
 * @property string $slug
 *
 * @property CatalogCategoryRelation $catalogCategoryRelation
 * @property CatalogCategoryRelation[] $catalogCategoryRelations
 * @property CatalogCategory[] $id2s
 * @property CatalogCategory[] $id1s
 * @property CatalogItem $catalogItem
 */
class CatalogCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalog_category';
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
                'in_attribute' => 'name',
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
            [['published', 'sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'required'],
            [['descr'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['img_url', 'slug'], 'string', 'max' => 255],
            [['lang'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'img_url' => Yii::t('app', 'Img Url'),
            'published' => Yii::t('app', 'Published'),
            'lang' => Yii::t('app', 'Lang'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'sort' => Yii::t('app', 'Sort'),
            'descr' => Yii::t('app', 'Descr'),
            'slug' => Yii::t('app', 'Slug'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogCategoryRelation()
    {
        return $this->hasOne(CatalogCategoryRelation::className(), ['id1' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogCategoryRelations()
    {
        return $this->hasMany(CatalogCategoryRelation::className(), ['id2' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId2s()
    {
        return $this->hasMany(CatalogCategory::className(), ['id' => 'id2'])->viaTable('catalog_category_relation', ['id1' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId1s()
    {
        return $this->hasMany(CatalogCategory::className(), ['id' => 'id1'])->viaTable('catalog_category_relation', ['id2' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogItem()
    {
        return $this->hasOne(CatalogItem::className(), ['category_id' => 'id']);
    }
}
