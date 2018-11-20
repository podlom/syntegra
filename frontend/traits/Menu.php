<?php

/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 14.12.2017
 * Time: 16:28
 */

namespace frontend\traits;


use Yii;
use frontend\traits\Lang;
use frontend\models\Menu as fMenu;


trait Menu
{
    public function setMenu()
    {
        Yii::$app->view->params['menu1'] = fMenu::getTopMenu1($this->lang);
       Yii::$app->view->params['menu2'] = fMenu::getBottomMenu1($this->lang);
       Yii::$app->view->params['menu3'] = fMenu::getBottomMenu2($this->lang);
       Yii::$app->view->params['menu4'] = fMenu::getBottomMenu3($this->lang);
        Yii::$app->view->params['menu5'] = fMenu::getBottomMenu4($this->lang);
        /*Yii::$app->view->params['menu6'] = fMenu::getBottomMenu4($this->lang);
        Yii::$app->view->params['menu7'] = fMenu::getBottomMenu5($this->lang);*/
    }
}