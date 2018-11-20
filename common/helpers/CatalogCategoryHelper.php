<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 18.05.2017
 * Time: 16:17
 */

namespace common\helpers;


use Yii;
use common\models\CatalogCategory;
use common\models\CatalogItem;


class CatalogCategoryHelper
{
    public static function getCategoryNameById($id)
    {
        $categoryData = CatalogCategory::findOne(intval($id));

        if ($categoryData !== null) {
            if (!empty($categoryData->name)) {
                return $categoryData->name;
            }
        }
    }

    public static function getCategoryBySlug($slug)
    {
        $categoryData = CatalogCategory::findOne(['slug' => \Yii::$app->db->quoteSql($slug), 'published' => 1]);

        if (!empty($categoryData)) {
            return $categoryData;
        }
    }

    public static function getCategories()
    {
        $categories = CatalogItem::find()
            ->select('catalog_category.*, catalog_item.category_id')
            ->leftJoin('catalog_category', 'catalog_item.category_id = catalog_category.id')
            ->where([
                'catalog_category.published' => 1,
                'catalog_category.lang' => Yii::$app->language,
            ])
            ->andFilterWhere(['<>', 'catalog_item.category_id', 'NULL'])
            ->orderBy(['catalog_category.sort' => SORT_ASC])
            ->groupBy('catalog_item.category_id')
            ->asArray()
            ->all();

        if (!empty($categories)) {
            return $categories;
        }
    }
}
