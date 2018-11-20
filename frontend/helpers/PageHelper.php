<?php
/**
 * Created by PhpStorm.
 * User: nevinchana
 * Date: 3/2/2018
 * Time: 10:17 AM
 */

namespace frontend\helpers;

use backend\models\Technologies;
use backend\models\Team;
use backend\models\Reviews;
use backend\models\Vacancies;
use Yii;

class PageHelper
{
    public static function getTechnologies(){
        return Technologies::find()->where(['slug'=>'technologies', 'published'=>1])->orderBy('sort')->all();
    }

    public static function getPartners(){
        return Technologies::find()->where(['slug'=>'partner', 'published'=>1])->orderBy('sort')->all();
    }

    public static function getOurTeam(){
        return Team::find()->where(['published'=>1])->andWhere(['lang'=>Yii::$app->language])->orderBy('id')->all();
    }

    public static function getReviews(){
        return Reviews::find()->where(['published'=>1])->orderBy('id')->all();
    }

    public static function getVacancies(){
        return Vacancies::find()->where(['published'=>1])->orderBy('id')->all();
    }

    

}