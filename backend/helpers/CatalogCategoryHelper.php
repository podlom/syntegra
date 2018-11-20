<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 28.03.2017
 * Time: 11:53
 */

namespace backend\helpers;


use common\models\CatalogCategory;


class CatalogCategoryHelper
{
    public static function getCategories($lang)
    {
        static $data = null;

        if ($data === null) {
            $data = CatalogCategory::find()
                ->select('name')
                ->indexBy('id')
                ->where([
                    'lang' => $lang,
                    'published' => 1,
                ])
                ->asArray()
                ->column();

            asort($data);
        }

        return $data;
    }
}
