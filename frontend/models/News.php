<?php

namespace frontend\models;


use Yii;
use common\models\News as CommNews;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;


class News extends CommNews
{
    public function getBySlug($slug, $lang)
    {
        $news = self::find()
            ->select('id, pubdate, title, body, source, img_url, slug')
            ->where([
                'slug' => \Yii::$app->db->quoteSql($slug),'lang'=>Yii::$app->language,
                'published' => 1,
            ])
            ->one();

        if (!empty($news)) {
            $news->img_url = Url::to(Yii::getAlias('@web') . $news->img_url);
            return $news;
        }

        throw new NotFoundHttpException();
    }

    public function getLatestNews($num = 4, $lang = null)
    {
        $num = intval($num);

        if (is_null($lang)) {
            $lang = Yii::$app->language;
        }

        $lastNews = self::find()
            ->select('id, pubdate, title, announce, source, img_url')
            ->where([
                'published' => 1,
                'lang' => \Yii::$app->db->quoteSql($lang),
            ])
            ->orderBy(['id' => SORT_DESC])
            ->limit($num)
            ->all();

        if ($lastNews) {
            return $lastNews;
        }
    }

    public function getAllNews($limit, $offset = 0, $lang = null)
    {
        if (is_null($lang)) {
            $lang = Yii::$app->language;
        }

        $limit = intval($limit);
        $offset = intval($offset);

        $lastNews = self::find()
            ->select('id, slug, pubdate, title, announce, source, img_url')
            ->where([
                'published' => 1,'lang'=>Yii::$app->language,
                'lang' => \Yii::$app->db->quoteSql($lang),
            ])
            ->orderBy(['id' => SORT_ASC])
            ->limit($limit)
            ->offset($offset)
            ->all();

        $cntQuery = Yii::$app->db->createCommand('
          SELECT COUNT(id) FROM news WHERE published=:published AND lang=:lang
        ', [':published' => 1, ':lang' => $lang])->queryScalar();

        $cntQuery -= $offset;

        if ($lastNews) {
            return [
                'lastNews' => $lastNews,
                'cntNews'  => $cntQuery,
            ];
        }
    }


}