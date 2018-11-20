<?php

namespace frontend\models;


use Yii;
use common\models\PartnerCategory as CommPartner;
// use yii\web\NotFoundHttpException;


class PartnerCategory extends CommPartner
{
    public function getPartnerCategories($lang = null)
    {
        if (is_null($lang)) {
            $lang = 'ru';
        }

        $partners_category = self::find()
            ->select('id, title, slug')
            ->where([
                'lang' => \Yii::$app->db->quoteSql($lang),
                'published' => 1,
            ])
            ->orderBy(['sort' => SORT_ASC])
            ->all();

        if (!empty($partners_category)) {
            return $partners_category;
        }

    }
}