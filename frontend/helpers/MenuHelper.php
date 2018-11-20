<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 28.03.2017
 * Time: 16:06
 */

namespace frontend\helpers;


use common\models\Menu;
use common\models\PageCategory;
use frontend\models\Page;

class MenuHelper
{
    public static function getTopMenu($lang = null)
    {
        if (is_null($lang)) {
            $lang = Yii::$app->language;
        }

        $menuItems = Menu::find()
            ->select('id, title, url, lang, sort, type, published')
            ->where([
                'published' => 1,
                'type' => 1,
                'lang' => \Yii::$app->db->quoteSql($lang),
            ])
            ->orderBy(['sort' => SORT_ASC])
            ->all();

        if (!empty($menuItems)) {
            return $menuItems;
        }
    }

    public static function getSubMenu($id, $lang){
        $pages = Page::find()
            ->where(['page.category_id'=>$id])
            ->andWhere(['lang'=>$lang])
            ->all();
        return $pages;
    }
    public static function getSubMenuBySlug($slug, $lang){

        $category = PageCategory::find()->where(['slug'=>$slug, 'lang'=>$lang])->one();


        $pages = Page::find()
            ->where(['page.category_id'=>$category->id])
            ->andWhere(['lang'=>$lang])
            ->all();
        return $pages;
    }
}