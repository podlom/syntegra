<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 28.03.2017
 * Time: 11:53
 */

namespace common\helpers;


use common\models\NewsCategory;


class NewsCategoryHelper
{
    public static function getCategoryTitleById($id)
    {
        $categoryData = NewsCategory::findOne(intval($id));

        if ($categoryData !== null) {
            if (!empty($categoryData->title)) {
                return $categoryData->title;
            }
        }
    }
}
