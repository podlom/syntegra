<?php

namespace frontend\controllers;


use Yii;
use yii\web\Controller;
use common\models\Meta;
use frontend\models\SearchForm;
// use frontend\models\Menu;
use frontend\traits\Lang;
use frontend\traits\Menu;
use frontend\traits\SeoMetaParams;
use frontend\traits\Settings;
//


/**
 * Site controller
 */
class SearchController extends Controller
{
    /**
     * Use traits
     */
    use Lang, Menu, SeoMetaParams, Settings;

    public function actionResult()
    {
        /*
        Yii::$app->view->params['langActive'] = Yii::$app->language;
        Yii::$app->view->params['lang'] = strtoupper(Yii::$app->language);
        Yii::$app->view->params['menu1'] = Menu::getTopMenu1(Yii::$app->language);
        Yii::$app->view->params['menu3'] = Menu::getBottomMenu1(Yii::$app->language);

        $reqUri = Yii::$app->request->getPathInfo();
        if (empty(Yii::$app->request->getPathInfo())) {
            if (Yii::$app->language !== 'ru') {
                $reqUri .= Yii::$app->language;
            }
        }
        Yii::$app->view->params['requestUri'] = $reqUri;
        $meta = Meta::findOneByUrl(Yii::$app->view->params['requestUri']);
        Yii::$app->view->params['meta_image'] = $meta->meta_image;
        Yii::$app->view->params['og_image'] = $meta->og_image;
        Yii::$app->view->params['og_title'] = $meta->og_title;
        Yii::$app->view->params['og_description'] = $meta->og_description;
        */

        $this->setLang();
        $this->setMenu();
        $this->setSeoMetaParams();
        $this->setSettings();

        // Yii::trace('Request query params: ' . var_export(Yii::$app->request->queryParams, 1), __METHOD__);

        $searchResults = ['queryParams' => Yii::$app->request->queryParams];
        // $searchResults = ['queryParams' => Yii::$app->request->post()];

        $searchForm = new SearchForm();
        $newsSearchData = $searchForm->searchNewsLike(Yii::$app->request->queryParams['search']);
        $foundNews = $newsSearchData->getModels();
        $pageSearchData = $searchForm->searchPageLike(Yii::$app->request->queryParams['search']);
        $foundPages = $pageSearchData->getModels();

        // Yii::trace('$newsSearchData: ' . var_export($newsSearchData, 1), __METHOD__);

        return $this->render('result', [
            'lang'          => $this->lang,
            'meta'          => $this->meta,
            'searchResults' => $searchResults,
            'foundNews'     => $foundNews,
            'foundPages'    => $foundPages,
        ]);
    }
}