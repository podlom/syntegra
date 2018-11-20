<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 12.06.2017
 * Time: 11:05
 */

namespace frontend\helpers;


use Yii;


class NavigationHelper
{
    public static function getUrlPrefix()
    {
        $urlPrefix = '/' . Yii::$app->language;
        if (Yii::$app->language == 'ru') { $urlPrefix = ''; }
        return $urlPrefix;
    }
}
