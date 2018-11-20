<?php
/**
 * Created by PhpStorm.
 * User: nevinchana
 * Date: 2/9/2018
 * Time: 4:16 PM
 */

namespace frontend\helpers;

use frontend\models\Page;
use Yii;

class SliderHelper
{

    public static function actionSlikServices()
    {
        $pages = (new Page())->getBySlugCategory('services', Yii::$app->language);
        return $pages;
    }
}