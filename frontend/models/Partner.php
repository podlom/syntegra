<?php

namespace frontend\models;


use Yii;
use common\models\Partner as CommPartner;
// use yii\web\NotFoundHttpException;


class Partner extends CommPartner
{
    public function getPartners($limit, $offset=0,$lang = null, $partner_category=null)
    {
        if (is_null($lang)) {
            $lang = 'ru';
        }
        if(is_null($partner_category)){
            $partner_category = 'financial';
        }
        $limit = intval($limit);
        $offset = intval($offset);

        $partners = self::find()
            ->select('partner.id, partner.title, partner.logo_url, partner.short_description, partner.slug')
            ->leftJoin('partner_category pc', 'pc.id = partner.category_id')
            ->where([
                'partner.lang' => \Yii::$app->db->quoteSql($lang),
                'partner.published' => 1,
            ])
            ->andWhere(['pc.slug'=>$partner_category])
            //->orderBy(['sort' => SORT_ASC])
            ->limit($limit)
            ->offset($offset)
           //->createCommand()->rawSql;
        //echo $partners;die;
            ->all();

        if (!empty($partners)) {
            return $partners;
        }

        // error 404
        // throw new NotFoundHttpException();
    }

    public function getPartner($slug, $lang=null){
        if (is_null($lang)){
            $lang = 'ru';
        }
        if(is_null($slug)){
            $slug = 1;
        }

        $partner = self::find()
          //  ->select('id, title, logo_url, short_description, description')
            ->where([
                'lang' => \Yii::$app->db->quoteSql($lang),
                'published' => 1,
                'slug'=>$slug
            ])
            ->one();

        if (!empty($partner)) {
            return $partner;
        }

    }
}