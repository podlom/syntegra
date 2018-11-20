<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 28.03.2017
 */

namespace common\models;


class SlideCategory
{
    private static $slideCategory = [
        1 => 'Верхний №1',
        2 => 'Продукция №2',
        3 => 'О нас',
    ];

    public static function getSlideCategory()
    {
        return self::$slideCategory;
    }

    public static function getCategoryById($id)
    {
        $id = intval($id);

        if (isset(self::$slideCategory[$id])) {
            return self::$slideCategory[$id];
        }
    }
}
