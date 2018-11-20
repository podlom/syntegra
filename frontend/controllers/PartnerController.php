<?php

namespace frontend\controllers;


    use backend\models\PartnerTechnology;
    use Yii;
    use yii\web\Controller;
    use common\models\Meta;
    use frontend\models\Partner;
// use frontend\models\Menu;
    use frontend\traits\Lang;
    use frontend\traits\Menu;
    use frontend\traits\SeoMetaParams;
    use frontend\traits\Settings;
//


class PartnerController extends Controller
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

        $partner = (new Partner())->getPartner($slug, $this->lang);

        //var_dump($partner);

        $sibling_partners = Partner::find()->where(['<> ','slug', $slug])->andWhere(['lang'=>$this->lang])->limit(2)->all();



        return $this->render('index', [
            'meta'      => $this->meta,
            'lang'      => $this->lang,
            'partner'  => $partner,
            'sibling_partners'=>$sibling_partners,
        ]);
    }
}
