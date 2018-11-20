<?php
namespace backend\helpers;

use backend\models\GroupQuestions;
use backend\models\Questions;
use yii\helpers\ArrayHelper;


class QuestionsHelper
{

    public static function getGroupQuestions()
    {
        static $data = null;

        if ($data === null) {
            $data = [];
            $catalogColor = GroupQuestions::find()->all();
            if (!empty($catalogColor)) {
                $data = ArrayHelper::map($catalogColor, 'id', 'title');
            }
        }

        //var_dump($data);die();
        return $data;
    }

    public static function getQuestions()
    {
        static $data = null;

        if ($data === null) {
            $data = [];
            $questions = Questions::find()->all();
            if (!empty($questions)) {
                $data = ArrayHelper::map($questions, 'id', 'title');
            }
        }

        //var_dump($data);die();
        return $data;
    }
}