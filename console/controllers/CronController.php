<?php
namespace console\controllers;


use Yii;
use yii\base\InvalidParamException;
use yii\console\Controller;


/**
 * Cron commands
 */
class CronController extends Controller
{
    /**
     * Error log cleaner
     */
    public function actionErrorLogCleaner()
    {
        if (isset(Yii::$app->log->targets['db'])) {
            if (Yii::$app->log->targets['db'] instanceof \common\components\ErrorLog)
                Yii::$app->log->targets['db']->errorLogCleaner();
        }
    }
}
