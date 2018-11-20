<?php

namespace backend\controllers;

use Yii;
use backend\models\Questions;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\models\QuestionsSearch;
use backend\models\UploadQuestionFileForm;
use yii\web\UploadedFile;


class QuestionsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new QuestionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        // return $this->render('index');
    }


    /**
     * Displays a single Questions model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Questions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $jsonData = "";

        if(!empty($jsonData)){
            $formData = json_decode($jsonData, true);
            $jsonData = str_replace(["\n", "\r", "\t", ' '], '', $jsonData);
        }
        else{
            $formData = "";
            $jsonData = "";
        }

        $model = new Questions();

        if(Yii::$app->request->post()) {



                $post = Yii::$app->request->post();

                $model->json_data = $post['data_form'];
                $model->id_group = $post['question_group_id'];
                $model->image = UploadedFile::getInstance($model, 'image');

                $model->title = $post['title'];
                if (!empty($model->json_data)) {
                    $model->json_data = str_replace(["\n", "\r", "\t"], '', $model->json_data);
                }

                if ($model->validate()) {
                    if ($model->image) {
                        $filePath = '/uploads/' . $model->image->baseName . '.' . $model->image->extension;
                        if ($model->image->saveAs($filePath)) {
                            $model->image = $filePath;
                            $model->save();
                            echo $model->id;
                        }

                    }

                    if ($model->save(false)) {
                        echo $model->id;
                    }
                }

                //return $this->redirect(['view', 'id' => $model->id]);


        }
        else{

            return $this->render('create', [
                'model' => $model,
                'data' => $formData,
                'jsonData' => $jsonData,
            ]);
        }
    }

    /**
     * Updates an existing Questions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $jsonData = $formData= $model->json_data;

        if (Yii::$app->request->post()) {


            $model->updated_at = date("Y-m-d H:i:s");
            $post = Yii::$app->request->post();


            $model->json_data = $post['data_form'];
            $model->title = $post['title'];

            $model->id_group = $post['question_group_id'];
            $model->image = $post['image'];
            $model->lang = $post['lang'];

            if (!empty($model->json_data)) {
                $model->json_data = str_replace(["\n", "\r", "\t"], '', $model->json_data);
            }
           // var_dump($post['image']);die;

            if ($model->validate()) {
                $model->save();
            } else {
                Yii::error('Errors validating model: ' . print_r($model->getErrors(), 1), __METHOD__);
            }

            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('update', [
                'model' => $model, 'data' => $formData,
                'jsonData' => $jsonData
            ]);
        }
    }
   /**
     * Deletes an existing Questions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Questions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Questions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Questions::findOne($id)) !== null) {

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

        public function actionUploadImg()
    {
        $model = new UploadQuestionFileForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            Yii::trace('$model->file: ' . var_export($model->imageFile, 1));
            if ($model->upload()) {
                // file is uploaded successfully
                Yii::trace('File was uploaded successfully: ' . $model->imageFile->name);
                return '/uploads/files/' . $model->imageFile->name;
            } else {
                return '';
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_upload_file', [
                    'model' => $model,
                ]
            );
        }
    }

}
