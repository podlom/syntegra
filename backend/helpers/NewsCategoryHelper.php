<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 28.03.2017
 * Time: 11:53
 */

namespace backend\helpers;


use common\models\NewsCategory;


class NewsCategoryHelper
{
    public static function getCategories()
    {
        static $data = null;

        if ($data === null) {
            $data = NewsCategory::find()
                ->select('title')
                ->indexBy('id')
                ->where(['published' => 1])
                ->asArray()
                ->column();

            asort($data);
        }

        return $data;
    }
}
