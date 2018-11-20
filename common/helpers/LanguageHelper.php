<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 31.03.2017
 * Time: 10:55
 */

namespace common\helpers;


class LanguageHelper
{
    public static function getSiteLanguages()
    {
        return require(__DIR__ . '/../config/lang.php');
    }

    public static function getSiteLanguages1()
    {
        $l = require(__DIR__ . '/../config/lang.php');
        return $l['languages'];
    }
}
