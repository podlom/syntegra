<?php

namespace frontend\controllers;


use Yii;
use common\models\Meta;
use frontend\models\News;
// use frontend\models\Menu;
use frontend\traits\Lang;
use frontend\traits\Menu;
use frontend\traits\SeoMetaParams;
use frontend\traits\Settings;
//


class NewsController extends \yii\web\Controller
{
    /**
     * Use traits
     */
    use Lang, Menu, SeoMetaParams, Settings;

    public function actionIndex()
    {
        $this->setLang();
        $this->setMenu();
        $this->setSeoMetaParams();
        $this->setSettings();

        Yii::$app->view->params['body_class'] = 'blog-page';

        $news = (new News())->getAllNews(4, 0, $this->lang);

        if (Yii::$app->request->isPost) {
            $defaultParams = [
                'limit' => 4,
                'offset' => 0,
                'lang' => null,
            ];

            $reqParams =  Yii::$app->request->post();

            $params = array_merge($defaultParams, $reqParams);

            if (is_null($params['lang'])) {
                $params['lang'] = $this->lang;
            }

            $newsData = (new News())->getAllNews($params['limit'], $params['offset'], $params['lang']);

            return $this->renderAjax('news1', [
                'news'    => $newsData['lastNews'],
                'cntNews' => $newsData['cntNews'],
            ]);
        } else {
            return $this->render('index', [
                'lang' => $this->lang,
                'meta' => $this->meta,
                'news'    => $news['lastNews'],
                'cntNews' => $news['cntNews'],
            ]);
        }

    }

    public function actionView($slug)
    {

        $this->setLang();
        $this->setMenu();
        $this->setSeoMetaParams();
        $this->setSettings();

        $lang = Yii::$app->language;
        $news = (new News())->getBySlug($slug,$lang);

        return $this->render('view', [
            'lang' => $this->lang,
            'meta' => $this->meta,
            'news' => $news,
        ]);
    }
}
