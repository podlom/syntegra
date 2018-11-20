<?php

namespace backend\controllers;


use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use common\models\Seometrics;
use backend\models\SeometricsForm;
use backend\models\SeometricsSearch;


class SeometricsController extends Controller
{
    /**
     * Поведения контроллера
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post']
                ],
            ],
        ];
    }

    /**
     * View seo metrics list
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SeometricsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * View seo metrics by id
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
     * Delete seo metrics by id
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Create new seo metrics
     * @return mixed
     */
    public function actionCreate($url = null)
    {
        $model = new SeometricsForm();

        if ($url) {
            $model->url = $url;
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $seometrics = new Seometrics();
            $model->setToModel($seometrics);
            $seometrics->save();
            return $this->redirect(['view', 'id' => $seometrics->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Update metadata by id
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $seometrics = $this->findModel($id);

        $model = new SeometricsForm();
        $model->setFromModel($seometrics);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->setToModel($seometrics);
            $seometrics->save();
            return $this->redirect(['view', 'id' => $seometrics->id]);
        } else {
            return $this->render('update', [
                'seometrics' => $seometrics,
                'model' => $model
            ]);
        }
    }

    /**
     * Find Seometrics by id
     * @param integer $id
     * @return Seometrics the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $seometrics = Seometrics::findOne($id);
        if ($seometrics) {
            return $seometrics;
        }
        throw new NotFoundHttpException();
    }
}
