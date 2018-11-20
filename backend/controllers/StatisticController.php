<?php

namespace backend\controllers;

use backend\helpers\StatisticHelper;
use Yii;
use backend\models\Questions;
use common\models\Answers;
use backend\models\QuestionsSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

class StatisticController extends \yii\web\Controller
{
    public function actionIndex($id)
    {

        $question = Questions::find()->where(['id'=>$id])->one();
        $answers = Answers::find()->where(['id_question'=>$id])->all();
        //var_dump($question);die();
        $data = StatisticHelper::getAnswersForQuestion($question, $answers);

        $title = $question->title;
         return $this->render('index', compact('data', 'title'));
    }



}
