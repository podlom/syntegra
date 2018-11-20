<?php

/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 14.12.2017
 * Time: 16:28
 */

namespace frontend\traits;


use Yii;


trait Lang
{
    public $lang;

    public function setLang()
    {
        $this->lang = Yii::$app->view->params['langActive'] = Yii::$app->view->params['lang'] = Yii::$app->language;
    }
}