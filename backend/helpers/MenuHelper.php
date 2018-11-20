<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 28.03.2017
 * Time: 11:53
 */

namespace backend\helpers;


use common\models\MenuType;


class MenuHelper
{
    public static function getMenuType()
    {
        static $data = null;

        if ($data === null) {
            $data = MenuType::getMenuType();
            asort($data);
        }

        return $data;
    }
}
