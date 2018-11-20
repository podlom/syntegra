<?php


namespace frontend\controllers;

use frontend\traits\Settings;
use common\models\Answers;
use Yii;
use yii\web\Controller;
use frontend\helpers\FormHelper;

class AnswersController extends Controller
{
    use Settings;

    public function actionSend()
    {
        $this->setSettings();

        $model = new Answers();

        if(Yii::$app->request->post()) {

                $post = Yii::$app->request->post();

                $model->json_data = $post['data_form'];
                $model->id_question = $post['question_id'];
                if (!empty($model->json_data)) {
                    $model->json_data = str_replace(["\n", "\r", "\t"], '', $model->json_data);
                }
                $model->save();

               $html =  FormHelper::sendMail($post['question_id'], $model->id);
                //var_dump(Yii::$app->view->params);die;
                Yii::$app
                    ->mailer
                    ->compose()
                    ->setFrom([Yii::$app->view->params['email'] => Yii::$app->name . ' robot'])
                    ->setTo( Yii::$app->view->params['email'])
                    ->setSubject('Новый ответ на форму № '.$post['question_id'].'')
                    ->setHtmlBody(' <div>
                                        <span>
                                            <span>Ответы на форму №'.$post['question_id'].'</span>
                                            
                                            <span>'.$html.'</span>
                                        </span>
                                    </div>')
                    ->send();


        }
        else{

        }
    }


}
