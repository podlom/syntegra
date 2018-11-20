<?php
namespace frontend\helpers;

use backend\models\Questions;
use common\models\Answers;
use backend\helpers\StatisticHelper;

class FormHelper
{



    public static function sendMail($form_id, $insert_last_id)
    {
        $question = Questions::find()->where(['id' => $form_id])->one();
        $answers = Answers::find()->where(['id_question' => $form_id, 'id'=>$insert_last_id])->all();
        //var_dump($question);die();
        $data = StatisticHelper::getAnswersForQuestion($question, $answers);

        $html = '';
        if(!empty($data)){
            foreach ($data as $v){
                if(is_array($v)) {
                    foreach ($v as $v1) {
                        $html .= $v1['title'] . " : " . $v1['value'].", ";
                    }

                }
            }
        }
        return $html;
    }

    public static function getIpAddress(){

            $ipaddress = '';
            if ($_SERVER['HTTP_CLIENT_IP'])
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            else if($_SERVER['HTTP_X_FORWARDED_FOR'])
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if($_SERVER['HTTP_X_FORWARDED'])
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            else if($_SERVER['HTTP_FORWARDED_FOR'])
                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            else if($_SERVER['HTTP_FORWARDED'])
                $ipaddress = $_SERVER['HTTP_FORWARDED'];
            else if($_SERVER['REMOTE_ADDR'])
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            else
                $ipaddress = 'UNKNOWN';

            return $ipaddress;

    }

    public static function getBlackListIP(){
        //return ['127.0.0.1', '127.0.0.2'];
        return [];
    }


    public static function isInBlackListIP(){
        $ipOfClient = self::getIpAddress();
        if(in_array($ipOfClient, self::getBlackListIP())){
            return true;
        }
        return false;
    }

    public static function getDownloadFileUrl($question_id){
        $question = Questions::find()->where(['id'=>$question_id])->one();
        return $question->image;
    }
}