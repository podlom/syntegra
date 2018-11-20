<?php

/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 22.12.2017
 * Time: 12:48
 */

namespace frontend\traits;


use Yii;


trait Settings
{
    public $settings;

    public function setSettings()
    {
        $this->settings = Yii::$app->settings;

        Yii::$app->view->params['phone1'] = $this->settings->get('phone1');
        Yii::$app->view->params['skype'] = $this->settings->get('skype');
        Yii::$app->view->params['domain'] = $this->settings->get('domain');
        Yii::$app->view->params['email'] = $this->settings->get('email');
        Yii::$app->view->params['title_main'] = $this->settings->get('title_main');
    }
}