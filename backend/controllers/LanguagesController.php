<?php
/**
 * Created by PhpStorm.
 * User: nevinchana
 * Date: 2/28/2018
 * Time: 11:18 AM
 */

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Languages;
use backend\models\LanguagesSearch;
use yii\web\NotFoundHttpException;

class LanguagesController extends Controller
{
    public function actionIndex()
    {

        $searchModel = new LanguagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        // return $this->render('index');
    }


    /**
     * Displays a single Languages model.
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
     * Creates a new Languages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Languages();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
            $this->createFileConfig();
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Languages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->createFileConfig();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Deletes an existing Languages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $this->createFileConfig();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Languages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Languages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Languages::findOne($id)) !== null) {

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    public function createFileConfig(){

        $langs = Languages::find()->select('short_name, name')->all();
        $l1='';
        foreach ($langs as $l){
            $l1.="'".$l->short_name."'=>'". $l->name."',";
        }
        $l1 = substr($l1, 0, -1);

        $file = '../../common/config/lang.php';
        // Открываем файл для получения существующего содержимого
        $current = file_get_contents($file);
        // Добавляем нового человека в файл
        $current = "<?php return ['languages'=>
            [".$l1."]
         ];";
        // Пишем содержимое обратно в файл
        file_put_contents($file, $current);
    }

}