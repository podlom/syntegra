<?php

namespace frontend\controllers;


use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\SurveyForm;
use common\models\Contact;
use common\models\CoworkingRequest;
use common\models\Page;

use frontend\models\Page as Page1;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Slide;
use frontend\traits\Lang;
use frontend\traits\Menu;
use frontend\traits\SeoMetaParams;
use frontend\traits\Settings;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * Use traits
     */
    use Lang, Menu, SeoMetaParams, Settings;

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->setLang();
        $this->setMenu();
        $this->setSeoMetaParams();
        $this->setSettings();
        Yii::$app->view->params['body_class'] = 'home-page';

        $lang = Yii::$app->language;

        $page = (new Page1())->getBySlug('home', $lang);
        $url_prefix = '';
        if(Yii::$app->language !='ru' ){
            $url_prefix = '/'.Yii::$app->language;
        }

        return $this->render('index', [
            'lang'           =>  $this->lang,
            'meta'           =>  $this->meta,
            'page'           =>  $page,
            'url_prefix'=>$url_prefix

        ]);
    }


    public function actionContact()
    {
        $this->setLang();
        $this->setMenu();
        $this->setSeoMetaParams();
        $this->setSettings();

        Yii::$app->view->params['body_class'] = 'contact-page';

        $page = Page::find()
            ->where([
                'published' => 1,
                'lang' => $this->lang,
                'slug' => 'kontakty',
            ])
            ->one();

        $model = new \frontend\models\ContactForm();

        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post();
            //
            // Yii::info('POST data: ' . var_export($postData, 1));
            //
            $cont = new Contact();
            $cont->name = trim(strip_tags($postData['ContactForm']['name']));
            $cont->email = trim(strip_tags($postData['ContactForm']['email']));
            $cont->message = trim(strip_tags($postData['ContactForm']['body']));
            $cont->server = serialize($_SERVER);
            if ($cont->validate()) {
                $cont->save();
                Yii::info('Valdated & saved model');
                Yii::$app->session->setFlash('success', Yii::t('app', 'Thank you for your request. We will contact you as soon as possible.'));
            } else {
                Yii::$app->getSession()->setFlash('error', Yii::t('app', 'There was an error sending your message.'));
                Yii::info('Errors validating model: ' . var_export($cont->getErrors(), 1));
            }
            //
            // return Json::encode(\yii\widgets\ActiveForm::validate($model));
            // $resVal = Json::encode(\yii\widgets\ActiveForm::validate($model));
            // Yii::info('Contact model validation result: ' . var_export($resVal, 1), __METHOD__);
            //
            $this->redirect('/site/contact#contact-message');
        } else {
            return $this->render('contact', [
                'model' => $model,
                'page'  => $page,
            ]);
        }
    }

    public function actionCoworkingRequest()
    {
        $model = new CoworkingRequest();

        $postData = Yii::$app->request->post();
        // Filling in created_at and server fields automatically
        $postData['CoworkingRequest']['server'] = serialize($_SERVER);
        $postData['CoworkingRequest']['created_at'] = date('Y-m-d H:i:s');

        if ($model->load($postData)) {
            // Yii::trace('POST data: ' . var_export($postData, 1));
            //
            if ($model->validate()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Thank you for your request. We will contact you as soon as possible.'));
                // TODO: send email notification
                $model->save();
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'There was an error sending your message.'));
            }
        }

        if (Yii::$app->request->isAjax) {
            $redirectTo = '/site/index';
            if (!empty($_SERVER['HTTP_REFERER'])) {
                $redirectTo = $_SERVER['HTTP_REFERER'];
            }
            // $redirectTo .= '#request-result-msg';
            // Yii::trace('Redirecting to: ' . $redirectTo);
            $this->redirect($redirectTo);
        } else {
            return $this->render('coworking-request', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Display sitemap
     */
    public function actionSitemap()
    {
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/xml');
        $sitemap = file_get_contents(Yii::getAlias('@frontend').'/web/sitemap/syntegra.tpl');
        $sitemap = str_replace('{host}', Url::home(true), $sitemap);
        return $sitemap;
    }

   public function actionContactFormAcept()
    {

        $model = new Contact();

        if ($model->load(Yii::$app->request->post())) {
            $model->server = serialize($_SERVER);
            $model->created_at = date('Y-m-d H:i:s');
            if ($model->validate()) {
                $model->save();
                return $this->redirect(Yii::$app->request->referrer);
            }

        }

    }

}
