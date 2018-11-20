<?php

namespace frontend\models;


use Yii;
use yii\base\Model;
use yii\helpers\Url;
use common\models\Menu as CommMenu;


/**
 * Front-end menu model
 */
class Menu extends Model
{
    public static function getTopMenu1($lang = null)
    {
        if (is_null($lang)) {
            $lang = Yii::$app->language;
        }

        $menu1 = self::_getMenu(1, $lang);

        if (!empty($menu1)) {
            return $menu1;
        }
    }

    public static function getTopMenu2($lang = null)
    {
        if (is_null($lang)) {
            $lang = Yii::$app->language;
        }

        $menu1 = self::_getMenu(2, $lang);

        if (!empty($menu1)) {
            return $menu1;
        }
    }

    public static function getBottomMenu1($lang = null)
    {
        if (is_null($lang)) {
            $lang = Yii::$app->language;
        }

        $menu3 = self::_getMenu(3, $lang);

        if (!empty($menu3)) {
            return $menu3;
        }
    }

    public static function getBottomMenu2($lang = null)
    {
        if (is_null($lang)) {
            $lang = Yii::$app->language;
        }

        $menu3 = self::_getMenu(4, $lang);

        if (!empty($menu3)) {
            return $menu3;
        }
    }

    public static function getBottomMenu3($lang = null)
    {
        if (is_null($lang)) {
            $lang = Yii::$app->language;
        }

        $menu3 = self::_getMenu(5, $lang);

        if (!empty($menu3)) {
            return $menu3;
        }
    }

    public static function getBottomMenu4($lang = null)
    {
        if (is_null($lang)) {
            $lang = Yii::$app->language;
        }

        $menu3 = self::_getMenu(6, $lang);

        if (!empty($menu3)) {
            return $menu3;
        }
    }

    public static function getBottomMenu5($lang = null)
    {
        if (is_null($lang)) {
            $lang = Yii::$app->language;
        }

        $menu3 = self::_getMenu(7, $lang);

        if (!empty($menu3)) {
            return $menu3;
        }
    }

    private static function _getMenu($type, $lang) {
        $menu = CommMenu::find()
            ->select('id, sort, url, title, type, published, lang')
            ->where([
                'lang' => \Yii::$app->db->quoteSql($lang),
                'published' => 1,
                'type' => $type
            ])
            ->orderBy(['sort' => SORT_ASC, 'id' => SORT_ASC])
            ->asArray()
            ->all();

        if (!empty($menu)) {
            return $menu;
        }
    }
}