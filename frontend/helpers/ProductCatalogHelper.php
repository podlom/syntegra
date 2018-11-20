<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 25.05.2017
 * Time: 12:23
 */

namespace frontend\helpers;


use Yii;
use common\models\CatalogItem;
use common\models\CatalogCategory;
use common\models\CatalogItemVariant;
use common\models\CatalogItemImage;


class ProductCatalogHelper
{
    public static function getCatalogItemVariants($productId)
    {
        $productId = intval($productId);

        $catItVa = CatalogItemVariant::find()
            ->select(['id', 'product_id', 'articul', 'color_id', 'img_url'])
            ->where([
                'published' => 1,
                'lang' => Yii::$app->language
            ])
            ->andWhere(['product_id' => $productId])
            ->groupBy(['color_id'])
            ->orderBy(['sort' => SORT_ASC])
            ->asArray()
            ->all();

        if (!empty($catItVa)) {
            return $catItVa;
        }
    }

    public static function getCatalogItemBySlug($slug)
    {
        return CatalogItem::findOne([
            'slug' => \Yii::$app->db->quoteSql($slug),
            'published' => 1,
            'lang' => Yii::$app->language
        ]);
    }

    public static function getCatalogCategory($catId)
    {
        $catId = intval($catId);

        $category = CatalogCategory::find()
            ->select('id, slug, name')
            ->where([
                'published' => 1,
                'lang' => Yii::$app->language
            ])
            ->andWhere(['id' => $catId])
            ->one();

        if (!empty($category)) {
            return $category;
        }
    }

    public static function getRelatedProducts($catId, $prId)
    {
        $catId = intval($catId);
        $prId = intval($prId);

        $relatedProducts = CatalogItem::find()
            ->where([
                'published' => 1,
                'lang' => Yii::$app->language
            ])
            ->andWhere(['category_id' => $catId])
            ->andFilterWhere(['!=', 'id', $prId])
            ->all();

        if (!empty($relatedProducts)) {
            return $relatedProducts;
        }
    }

    public static function getProdVarFilterOpts($catId)
    {
        $productFilter1Options = [];
        for ($n = 1; $n <= 4; $n++) {
            $filtData = CatalogItem::findBySql('SELECT id, title FROM catalog_subcategory' . $n . ' WHERE published = 1 AND id IN (SELECT DISTINCT(sub_category' . $n . '_id) FROM catalog_item_variant WHERE published = 1 AND sub_category' . $n . '_id <> 0 AND product_id IN (SELECT id FROM catalog_item WHERE published = 1 AND category_id = ' . intval($catId) . '))')
                ->asArray()
                ->all();
            // Yii::info('Filer' . $n . ' data: ' . var_export($filtData, 1));

            if (!empty($filtData)) {
                foreach ($filtData as $fa1) {
                    $productFilter1Options[] = [
                        'filter_id' => $n,
                        'id' => $fa1['id'],
                        'title' => $fa1['title'],
                        'category_id' => intval($catId),
                    ];
                }
            }
        }
        return $productFilter1Options;
    }

    public static function getProdByCat($k)
    {
        $products = CatalogItem::find()
            ->where([
                'published' => 1,
                'lang' => Yii::$app->language
            ])
            ->andWhere(['category_id' => intval($k)])
            ->orderBy(['sort' => SORT_ASC])
            ->all();

        if (!empty($products)) {
            return $products;
        }
    }

    private static function _getProdsBySubCat($a, $c)
    {
        $c = intval($c);

        $sWhere = '';
        foreach ($a as $i => $v) {
            $s1 = substr($v, 10);
            // Yii::info('id str: ' . print_r($s1, 1));
            $a1 = explode('][', $s1);
            // Yii::info('id str: ' . print_r($a1, 1));
            $i = intval($a1[0]);
            $j = intval(trim($a1[1], ']'));
            // Yii::info('iSubCat: ' . $i . '; jSubVal: ' . $j . '; Cat: ' . $c);
            $sWhere .= " AND ci.category_id = {$c} AND civ.sub_category{$i}_id IS NOT NULL AND civ.sub_category{$i}_id = {$j}";
        }

        $products = CatalogItem::findBySql("SELECT ci.*, civ.img_url AS image, civ.articul, civ.sub_category1_id, civ.sub_category2_id, civ.sub_category3_id, civ.sub_category4_id 
  FROM catalog_item ci 
  LEFT JOIN catalog_item_variant civ ON civ.product_id = ci.id
  WHERE ci.published = 1
  AND civ.lang = '" . Yii::$app->language . "'
  {$sWhere}
  GROUP BY ci.id
  ORDER BY ci.sort")
            ->all();

        if (!empty($products)) {
            // Yii::info('prod0 id: ' . var_export($products[0]->id, 1));
            return $products;
        } else {
            Yii::info('No products with matching criteria found.');
        }
    }

    public static function getProdBySubcat($aSubCatFilters, $catId)
    {
        // Yii::info('F1: ' . print_r($aSubCatFilters, 1));
        $products = self::_getProdsBySubCat($aSubCatFilters, $catId);

        if (!empty($products)) {
            return $products;
        } else {
            Yii::info('No products with matching criteria found.');
        }
    }

    public static function getVideoConsultant($categoryId)
    {
        $categoryId = intval($categoryId);

        $videoConsultant1 = \common\models\VideoConsultant::find()
            ->select('*')
            ->where(['published' => 1, 'lang' => Yii::$app->language])
            ->andWhere(['category_id' => 0])
            ->orderBy(['sort' => SORT_ASC])
            ->all();

        $videoConsultant2 = \common\models\VideoConsultant::find()
            ->select('*')
            ->where(['published' => 1, 'lang' => Yii::$app->language])
            ->andWhere(['category_id' => $categoryId])
            ->orderBy(['sort' => SORT_ASC])
            ->all();

        $videoConsultant = array_merge($videoConsultant2, $videoConsultant1);

        if (!empty($videoConsultant)) {
            return $videoConsultant;
        }
    }

    public static function getDefaultItemVariant($productId)
    {
        $productId = intval($productId);

        return CatalogItemVariant::findOne(['product_id' => $productId, 'default' => 1, 'published' => 1, 'lang' => Yii::$app->language]);
    }

    public static function getProductItemGallery($productId)
    {
        $productId = intval($productId);

        return CatalogItemImage::find()
            ->select('img_url')
            ->where(['item_id' => $productId, 'published' => 1])
            ->orderBy(['sort' => SORT_ASC])
            ->asArray()
            ->all();
    }
}