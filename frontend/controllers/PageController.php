<?php

namespace frontend\controllers;


use backend\models\Questions;
use Yii;
use yii\db\Query;
use yii\web\Controller;
use common\models\Meta;
use frontend\models\Page;
// use frontend\models\Menu;
use frontend\traits\Lang;
use frontend\traits\Menu;
use frontend\traits\SeoMetaParams;
use frontend\traits\Settings;
use frontend\models\News;
//


class PageController extends Controller
{
    /**
     * Use traits
     */
    use Lang, Menu, SeoMetaParams, Settings;

    public function actionIndex($slug)
    {
        $this->setLang();
        $this->setMenu();
        $this->setSeoMetaParams();
        $this->setSettings();

        Yii::$app->view->params['body_class'] = $slug.'-page';
        $lang = Yii::$app->language;
        $pages = (new Page())->getBySlugCategory($slug, $lang);

        $category = (new Page())->getCategory($slug);
    //var_dump($category);
        return $this->render('index', [
            'meta' => $this->meta,
            'lang' => $this->lang,
            'pages' => $pages,
            'category'=>$category,
        ]);
    }

    public function actionView($slug)
    {
        $this->setLang();
        $this->setMenu();
        $this->setSeoMetaParams();
        $this->setSettings();



    $lang = Yii::$app->language;
        $page = (new Page())->getBySlug($slug, $lang);

        $category = (new Query())->select(['title', 'slug','id'])->from('page_category')->where(['id'=>$page->category_id])->andWhere(['lang'=>Yii::$app->language])//->createCommand()->rawSql;
            ->one();
        $subpages = [];
        /*if($slug == 'go-servless'){
            $subpages = (new Page())->getBySlugCategory($slug, $lang);
            //var_dump($subpages);die;
        }
        if($slug == 'company'){
            $subpages = (new Page())->getBySlugCategory($slug, $lang);
            //var_dump($subpages);die;
        }*/
        if($slug == 'go-visual'){
            Yii::$app->view->params['body_class'] = 'services-item go-visual-page  page-item';
            $subpages = (new Page())->getBySlugCategory($slug, $lang);

        }
        else if($slug == 'go-visual1'){
            Yii::$app->view->params['body_class'] = 'services-item go-visual-page  page-item';
        }
        else {
            Yii::$app->view->params['body_class'] = $slug . '-page page-item';

            $subpages = (new Page())->getBySlugCategory($slug, $lang);
        }
        //var_dump($category);die;
       // $category = (new Page())->getCategory($slug);
        $formData = NULL;
        $jsonData=NULL;

        if($page->question_id !== NULL){
           $jsonData = Questions::findOne($page->question_id)->json_data;
           $formData = json_decode($jsonData, true);
           $jsonData = str_replace(["\n", "\r", "\t"], '', $jsonData);
        }
        else{

        }
        $news = (new News())->getAllNews(4,0,$lang);

        $url_prefix = '';
        if(Yii::$app->language !='ru' ){
            $url_prefix = '/'.Yii::$app->language;
        }


        //var_dump($news);die;
        return $this->render('view', [
            'meta' => $this->meta,
            'lang' => $lang,
            'page' => $page,
            'category'=>$category,
            'news'=>$news,
            'slug'=>$slug,
            'data'      =>  $formData,
            'jsonData'  =>  $jsonData,
            'subpages'=>$subpages,
            'url_prefix'=>$url_prefix,
        ]);
    }
}
