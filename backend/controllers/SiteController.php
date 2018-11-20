<?php

namespace backend\controllers;


use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\User;
use backend\helpers\UserHelper;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            $userName = (new User)->getUsername();
            Yii::$app->view->params['userName'] = $userName;
            // Yii::trace('$userName: ' . var_export($userName, 1));
            Yii::$app->view->params['isAdmin'] = UserHelper::isAdmin(Yii::$app->user->getId());
            Yii::$app->view->params['isEditor'] = UserHelper::isEditor(Yii::$app->user->getId());
        }

        $companyName = 'Syntegra';
        if (!empty(Yii::$app->params->companyName)) {
            $companyName = Yii::$app->params->companyName;
        }
        Yii::$app->view->params['companyName'] = $companyName;

        return $this->render('index', [
            'companyName'  =>  $companyName,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $companyName = 'Syntegra';
        if (!empty(Yii::$app->params->companyName)) {
            $companyName = Yii::$app->params->companyName;
        }
        Yii::$app->view->params['companyName'] = $companyName;

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $this->layout ='@backend/views/layouts/def_main';

            return $this->render('login', [
                'model'        =>  $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
