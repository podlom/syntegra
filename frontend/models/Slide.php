<?php

namespace frontend\models;


use Yii;
use common\models\Slide as CommSlide;


class Slide extends CommSlide
{
    private function _getSlidesByCategory($categoryId, $lang = null)
    {
        $categoryId = intval($categoryId);

        if (is_null($lang)) {
            $lang = Yii::$app->language;
        }

        // TODO: uncomment lang in where clause
        $slides = self::find()
            ->select('*')
            ->where([
                'lang' => \Yii::$app->db->quoteSql($lang),
                'category_id' => $categoryId,
                'published' => 1,
            ])
            ->orderBy(['sort' => SORT_ASC, 'id' => SORT_DESC])
            ->all();

        if ($slides) {
            return $slides;
        }
    }

    public function getSlides1($lang = null)
    {
        return $this->_getSlidesByCategory(1, $lang);
    }

    public function getSlides2($lang = null)
    {
        return $this->_getSlidesByCategory(2, $lang);
    }
}