<?php

/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 22.12.2017
 * Time: 16:23
 */

namespace common\models;


class MenuType
{
    private static $menuTypes = [
        1 => 'Верхнее 1',
        2 => 'Верхнее 2',
        3 => 'Нижнее 1',
        4 => 'Нижнее 2',
        5 => 'Нижнее 3',
        6 => 'Нижнее 4',
        7 => 'Нижнее 5',
    ];

    public static function getMenuType()
    {
        return self::$menuTypes;
    }
}
