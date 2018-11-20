<?php


namespace frontend\controllers;


use backend\models\Questions;
use Yii;
use yii\web\Controller;


class FormController extends Controller
{
    public function actionView($id)
    {
        $id = intval($id);

        $jsonData = Questions::findOne($id)->json_data;
        $title = Questions::findOne($id)->title;
        //var_dump($jsonData);die();

        $formData = json_decode($jsonData, true);
        //var_dump($formData);die();

        $jsonData = str_replace(["\n", "\r", "\t"], '', $jsonData);
        $url_prefix = '';
        if(Yii::$app->language !='ru' ){
            $url_prefix = '/'.Yii::$app->language;
        }

        return $this->render('test', [
            'id_question' => $id,
            'data'      =>  $formData,
            'title'=>$title,
            'jsonData'  =>  $jsonData,
            'url_prefix'=>$url_prefix
        ]);
    }


    public function actionCreateQuestion(){
        return $this->render('test');
    }

    public function actionSaveQuestion(){

    }


}
