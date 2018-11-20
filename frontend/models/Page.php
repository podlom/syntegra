<?php

namespace frontend\models;


use Codeception\Module\Db;
use Yii;
use common\models\Page as CommPage;
use yii\db\Expression;
use yii\db\Query;
use yii\web\NotFoundHttpException;


class Page extends CommPage
{
    public function getBySlug($slug, $lang)
    {
        $page = self::find()
            ->select('id, title, body, announce, category_id, img_url, question_id, title1, body1, title2, body2, title3, body3')
            ->where([
                'slug' => \Yii::$app->db->quoteSql($slug),
                'lang'=>$lang,
                'published' => 1,])
            //->createCommand()->rawSql;echo $page; die;
            ->one();

        if (!empty($page)) {
            return $page;
        }

        throw new NotFoundHttpException();
    }

    public function getBySlugCategory($slug, $lang){

        //echo (new Query)->select('id')->from('page_category')->where(['slug'=>$slug, 'lang'=>Yii::$app->language, 'published'=>1])->createCommand()->rawSql;die;

        $ids = (new Query)->select('id')->from('page_category')->where(['slug'=>$slug,'lang'=>Yii::$app->language, 'published'=>1])->scalar();

        //var_dump($ids);die;
        if($ids!==false){
            $pages = self::find()
                ->where([
                    'category_id' => $ids,
                    'lang'=>Yii::$app->language,
                    'published' => 1,])
                //->createCommand()->rawSql;echo  $pages;die;
            ->all();

            if (!empty($pages)) {
                return $pages;
            }

            throw new NotFoundHttpException();
        }
        else{
            return [];
        }


    }

    public function getCategory($slug){

        $category =(new Query)->select(['title', 'id', 'slug'])->from('page_category')->where(['slug'=>$slug, 'lang'=>Yii::$app->language, 'published'=>1])->one();

        if (!empty($category)) {
            return $category;
        }

        throw new NotFoundHttpException();
    }


}