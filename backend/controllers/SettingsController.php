<?php

namespace backend\controllers;


use Yii;
use pheme\settings\models\SettingSearch;
use pheme\settings\controllers\DefaultController;
use yii\base\ViewContextInterface;
use yii\filters\AccessControl;


/**
 * Контроллер настроек
 */
class SettingsController extends DefaultController implements ViewContextInterface
{
    /**
     * @return bool|string
     */
    public function getViewPath()
    {
        return Yii::getAlias('@vendor/pheme/yii2-settings/views/default/');
    }

    /**
     * @inheritDoc
     */
    protected function findModel($id)
    {
        $model = parent::findModel($id);

        if ($model && !$model->hidden) {
            return $model;
        } else {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @inheritDoc
     */
    public function actionIndex()
    {
        $searchModel = new SettingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['hidden' => false]);

        return $this->render(
            'index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }


}
