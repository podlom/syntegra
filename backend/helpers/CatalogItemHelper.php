<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 15.05.2017
 * Time: 13:18
 */

namespace backend\helpers;


use common\models\CatalogItem;


class CatalogItemHelper
{
    public static function getProducts()
    {
        static $data = null;

        if ($data === null) {
            $data = CatalogItem::find()
                ->select('sku')
                ->indexBy('id')
                ->where(['published' => 1])
                ->asArray()
                ->column();

            asort($data);
        }

        return $data;
    }

    public static function getProductTitleById($id)
    {
        $productData = CatalogItem::findOne(intval($id));

        if ($productData !== null) {
            if (!empty($productData->title)) {
                return $productData->title;
            }
        }
    }
}
