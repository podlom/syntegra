<?php

namespace backend\controllers;


use Yii;
use common\models\CatalogItemVariant;
use backend\models\CatalogItemVariantSearch;
use backend\models\UploadCatalogItemVariantImageForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;


/**
 * CatalogItemVariantController implements the CRUD actions for CatalogItemVariant model.
 */
class CatalogItemVariantController extends Controller
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
     * Lists all CatalogItemVariant models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CatalogItemVariantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CatalogItemVariant model.
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
     * Creates a new CatalogItemVariant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CatalogItemVariant();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CatalogItemVariant model.
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
     * Deletes an existing CatalogItemVariant model.
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
     * Finds the CatalogItemVariant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CatalogItemVariant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CatalogItemVariant::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionLoadCatOpts()
    {
        if (Yii::$app->request->isAjax) {
            $postData = Yii::$app->request->post();
            // Yii::info('POST: ' . var_export($postData, 1));
            $className = 'common\models\CatalogSubcategory' . $postData['subcategory_id'];
            // Yii::info('class: ' . $className);
            $subcategory = $className::find()->where(['lang' => $postData['lang'], 'published' => 1])->asArray()->all();
            $opts = ArrayHelper::map($subcategory, 'id', 'title');
            // Yii::info('opts: ' . var_export($opts, 1));
            $options[] = [
                'id' => 0,
                'title' => '...',
            ];
            if (!empty($opts)) {
                foreach ($opts as $oK => $oV) {
                    $options[] = [
                        'id' => $oK,
                        'title' => $oV,
                    ];
                }
            }
            return $this->renderAjax('//catalog-item/_ajax_load_cat_opts', [
                'options' => $options
            ]);
        }
    }

    public function actionUploadImg()
    {
        $model = new UploadCatalogItemVariantImageForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            Yii::trace('$model->image: ' . var_export($model->imageFile, 1));
            if ($model->upload()) {
                // file is uploaded successfully
                Yii::trace('File was uploaded successfully: ' . $model->imageFile->name);
                return '/images/product/' . $model->imageFile->name;
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
