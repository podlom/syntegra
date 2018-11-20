<?php
/**
 * Created by PhpStorm.
 * User: nevinchana
 * Date: 2/5/2018
 * Time: 1:08 PM
 */

namespace frontend\controllers;


use backend\helpers\PartnerHelper;
use frontend\models\Partner;
use Yii;
use yii\web\Controller;
use common\models\Meta;
use frontend\models\PartnerCategory;
use frontend\traits\Lang;
use frontend\traits\Menu;
use frontend\traits\SeoMetaParams;
use frontend\traits\Settings;



class PartnerCategoryController extends Controller
{

    use Lang, Menu, SeoMetaParams, Settings;

    public function actionIndex(){
        $this->setLang();
        $this->setMenu();
        $this->setSeoMetaParams();
        $this->setSettings();
        $cnt = 6;
        Yii::$app->view->params['body_class'] = 'partners-page';
        $partners_category = (new PartnerCategory())->getPartnerCategories(Yii::$app->language);

        $partnersData = (new Partner())->getPartners($cnt+1,0,Yii::$app->language, 'financial');
        $url_prefix = '';
        if(Yii::$app->language !='ru' ){
            $url_prefix = '/'.Yii::$app->language;
        }

        return $this->render('index', [
            'meta'      => $this->meta,
            'lang'      => $this->lang,
            'partners_category'  => $partners_category,
            'partnersData'=>$partnersData,
            'cnt'=>$cnt,
            'url_prefix'=>$url_prefix
        ]);
    }

    public function actionPartners(){
        $this->setLang();

        if (Yii::$app->request->isAjax) {
               // var_dump(Yii::$app->request);die;
            $postData = Yii::$app->request->post();
            $partner_category =  $postData['partner_category'];

            $partnersData = (new Partner())->getPartners($postData['limit'], $postData['offset'],Yii::$app->language, $partner_category);

            return $this->renderAjax('partnersAjax', [
                'partnersData'    => $partnersData,

            ]);

        }

    }
}