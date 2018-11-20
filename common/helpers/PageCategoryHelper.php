<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 28.03.2017
 */

namespace common\helpers;


use common\models\PageCategory;


class PageCategoryHelper
{
    public static function getCategoryTitleById($id)
    {
        $categoryData = PageCategory::findOne(intval($id));

        if ($categoryData !== null) {
            if (!empty($categoryData->title)) {
                return $categoryData->title;
            }
        }
    }
}
