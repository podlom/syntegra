<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 15.05.2017
 * Time: 13:18
 */

namespace backend\helpers;


use common\models\Partner;
use common\models\PartnerCategory;


class PartnerHelper
{
    public static function getPartnerCategory()
    {
        static $data = null;

        if ($data === null) {
            $data = PartnerCategory::find()
                ->select('title')
                ->indexBy('id')
                ->where(['published' => 1])
                ->asArray()
                ->column();

            asort($data);
        }

        return $data;
    }

  /*  public static function getProductTitleById($id)
    {
        $productData = PartnerCategory::findOne(intval($id));

        if ($productData !== null) {
            if (!empty($productData->title)) {
                return $productData->title;
            }
        }
    }*/
}
