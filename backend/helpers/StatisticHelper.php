<?php
namespace backend\helpers;

use backend\models\Questions;
use common\models\Answers;

use yii\helpers\ArrayHelper;


class StatisticHelper
{

    public static function getAnswersForQuestion($question, $answers)
    {

        $question_data = json_decode($question->json_data);
       //  var_dump($question_data);

        $data = [];
        $answer_data = []; // array of data from answers


        if(!empty($answers)){

            foreach ($answers as $ans2){
                $ans = $ans2->json_data;
                $answer_data1 = explode('&', $ans);
                foreach ($answer_data1 as $ans1) {
                    $arr = explode('=', $ans1);
                    $answer_data['answ'.$ans2->id][] = ['name' => $arr[0], 'value' => $arr[1]];
                }

            }
        }

      //var_dump($answer_data);die();


        $question_data1 = [];
        foreach ($question_data as $form_element){
            $question_data1[] = ['label' => $form_element->label, 'name' => $form_element->name, 'values' => $form_element->values];
        }


        foreach ($question_data1 as $elem){
            if(is_array($elem['values']) && !empty($elem['values']) && $elem['values']!=null){
                $data[] =1;
            }
            else{
                
            }
        }

        //var_dump($question_data1);die();


        foreach ($answer_data as $k=>$answer) {
            foreach ($answer as $elem) {
               // var_dump($elem);
                $val = $elem['value'];
                $name = $elem['name'];
                foreach ($question_data1 as $q){
                    if($q['name'] == $name){
                        $name = $q['label'];
                    }
                    if(is_array($q['values']) && !empty($q['values'])){
                        foreach ($q['values'] as $val1){
                            if($val1->value == $val){
                                $val = $val1->label;
                            }
                        }
                    }
                    else{
                        $val = urldecode($val);
                    }
                }

                $data[$k][] = ['title' => $name, 'value' => $val];
            }
        }

        return $data;
    }
}