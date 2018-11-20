<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 18.05.2017
 * Time: 17:17
 */

namespace common\helpers;


use common\models\CatalogItem;


class CatalogItemHelper
{
    public static function getCatalogItemById($id)
    {
        $catItemData = CatalogItem::findOne(intval($id));

        if (!empty($catItemData)) {
            return $catItemData;
        }
    }

    public static function getItemBySlug($slug)
    {
        $catItemData = CatalogItem::findOne(['slug' => \Yii::$app->db->quoteSql($slug), 'published' => 1]);

        if (!empty($catItemData)) {
            return $catItemData;
        }
    }

    public static function getCatalogItems($params = [])
    {
        $catItems = CatalogItem::find()
            ->select('*')
            ->where(['published' => 1]);

        if (isset($params['category_id'])) {
            $catItems->andWhere(['category_id' => $params['category_id']]);
        }

        $catItems
            ->all();

        if (!empty($catItems)) {
            return $catItems;
        }
    }
}
