<?php

namespace backend\controllers;


use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use common\models\Meta;
use backend\models\MetaForm;


class MetaController extends Controller
{
    /**
     * Controller's behavior
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
     * View list of metadata
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Meta::find()->orderBy('id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * View metadata by id
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
     * Delete metadata by id
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Redirect to create or edit page, depends on meta exsisting
     * @param string $url
     * @return mixed
     */
    public function actionEdit($url)
    {
        $meta = Meta::findOne(['url' => $url]);
        if ($meta) {
            return $this->redirect(['meta/update', 'id' => $meta->id]);
        }
        return $this->redirect(['meta/create', 'url' => $url]);
    }

    /**
     * Create new meta
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MetaForm();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if ($model->validate()) {
                $meta = new Meta();
                $model->setToModel($meta);
                if ($meta->save()) { }
                return $this->redirect(['view', 'id' => $meta->id]);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Update meta by id
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $meta = $this->findModel($id);

        $model = new MetaForm();
        $model->setFromModel($meta);

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if ($model->validate()) {
                $model->setToModel($meta);
                if ($meta->save()) { }
                return $this->redirect(['view', 'id' => $meta->id]);
            }
        }
        
        return $this->render('update', [
            'meta' => $meta,
            'model' => $model
        ]);
    }

    /**
     * Find metadata by id
     * @param integer $id
     * @return Meta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $meta = Meta::findOne($id);
        if ($meta) {
            return $meta;
        }
        throw new NotFoundHttpException();
    }
}
