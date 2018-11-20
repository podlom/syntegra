<?php

namespace backend\controllers;


use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use common\models\CatalogItemImage;
use backend\models\CatalogItemImageSearch;
use backend\models\UploadCatalogItemGalleryImageForm;


/**
 * CatalogItemImageController implements the CRUD actions for CatalogItemImage model.
 */
class CatalogItemImageController extends Controller
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
     * Lists all CatalogItemImage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CatalogItemImageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CatalogItemImage model.
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
     * Creates a new CatalogItemImage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CatalogItemImage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CatalogItemImage model.
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
     * Deletes an existing CatalogItemImage model.
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
     * Finds the CatalogItemImage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CatalogItemImage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CatalogItemImage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUploadImg()
    {
        $model = new UploadCatalogItemGalleryImageForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            Yii::trace('$model->imageFile: ' . var_export($model->imageFile, 1));
            if ($model->upload()) {
                // file is uploaded successfully
                Yii::trace('File was uploaded successfully: ' . $model->imageFile->name);
                return '/images/gallery/' . $model->imageFile->name;
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
