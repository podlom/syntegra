<?php

namespace frontend\models;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\News;
use frontend\models\Page;


class SearchForm extends Model
{
    /**
     * Создание провайдера данных
     * @param \yii\db\ActiveQuery $query
     * @return ActiveDataProvider
     */
    private function createDataProvider($query)
    {
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
    }

    /**
     * Создание базового запроса для поиска новостей
     * @param bool $rand
     * @return \yii\db\ActiveQuery
     */
    private function createNewsQuery($orderBy = false, $lang = null)
    {
        if (is_null($lang)) {
            $lang = Yii::$app->language;
        }

        $query = News::find()
            ->andWhere([
                'published' => 1,
                'lang' => $lang,
            ]);

        switch ($orderBy) {
            case 'title':
                $orderBy = ['title' => SORT_ASC];
                break;
            case 'rand':
                $orderBy = ['rand()' => SORT_DESC];
                break;
            default:
                $orderBy = ['id' => SORT_DESC];
                break;
        }

        $query->orderBy($orderBy);

        return $query;
    }

    /**
     * Получение провайдера данных для поиска игр по названию
     * @return ActiveDataProvider
     */
    public function searchNewsLike($search)
    {
        // получаем базовый запрос поиска новостей
        $query = $this->createNewsQuery();

        // применяем ограничения
        $query->andWhere('title LIKE :search', [':search' => '%' . $search . '%']);
        $query->orWhere('announce LIKE :searcha', [':searcha' => '%' . $search . '%']);
        $query->orWhere('body LIKE :searchb', [':searchb' => '%' . $search . '%']);

        return $this->createDataProvider($query);
    }

    private function createPageQuery($orderBy = false, $lang = null)
    {
        if (is_null($lang)) {
            $lang = Yii::$app->language;
        }

        $query = Page::find()
            ->andWhere([
                'published' => 1,
                'lang' => $lang,
            ]);

        switch ($orderBy) {
            case 'title':
                $orderBy = ['title' => SORT_ASC];
                break;
            case 'rand':
                $orderBy = ['rand()' => SORT_DESC];
                break;
            default:
                $orderBy = ['id' => SORT_ASC];
                break;
        }

        $query->orderBy($orderBy);

        return $query;
    }

    public function searchPageLike($search)
    {
        // получаем базовый запрос поиска страниц
        $query = $this->createPageQuery();

        // применяем ограничения
        $query->andWhere('title LIKE :search', [':search' => '%' . $search . '%']);
        $query->orWhere('announce LIKE :searcha', [':searcha' => '%' . $search . '%']);
        $query->orWhere('body LIKE :searchb', [':searchb' => '%' . $search . '%']);

        return $this->createDataProvider($query);
    }
}