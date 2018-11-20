<?php

namespace backend\controllers;


use Yii;
use common\models\CatalogCategory;
use backend\models\CatalogCategorySearch;
use backend\models\UploadCatalogCategoryImageForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;


/**
 * CatalogCategoryController implements the CRUD actions for CatalogCategory model.
 */
class CatalogCategoryController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CatalogCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CatalogCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CatalogCategory model.
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
     * Creates a new CatalogCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CatalogCategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CatalogCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CatalogCategory model.
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
     * Finds the CatalogCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CatalogCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CatalogCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUploadImg()
    {
        $model = new UploadCatalogCategoryImageForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            Yii::trace('$model->imageFile: ' . var_export($model->imageFile, 1));
            if ($model->upload()) {
                // file is uploaded successfully
                Yii::trace('File was uploaded successfully: ' . $model->imageFile->name);
                return '/images/category/' . $model->imageFile->name;
            } else {
                return '';
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_upload_image', [
                    'model' => $model,
                ]
            );
        }
    }
}
