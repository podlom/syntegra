<?php

/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 14.12.2017
 * Time: 16:28
 */

namespace frontend\traits;


use Yii;
use yii\helpers\Html;
use common\models\Meta;


trait SeoMetaParams
{
    public $reqUri;
    public $meta;
    public $metaDescription;
    public $metaKeywords;

    public function setSeoMetaParams()
    {
        $this->reqUri = Yii::$app->request->getPathInfo();
        Yii::$app->view->params['requestUri'] = $this->reqUri;

        Yii::$app->view->params['meta'] = $this->meta = Meta::findOneByUrl($this->reqUri);
        Yii::$app->view->params['title'] = $this->meta->title;
        Yii::$app->view->params['meta_image'] = $this->meta->meta_image;
        Yii::$app->view->params['og_image'] = $this->meta->og_image;
        Yii::$app->view->params['og_title'] = $this->meta->og_title;
        Yii::$app->view->params['og_description'] = $this->meta->og_description;

        $this->metaDescription = Html::encode($this->meta->description);
        if (!empty($this->metaDescription)) {
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => $this->metaDescription,
            ]);
        }

        $this->metaKeywords = Html::encode($this->meta->keywords);
        if (!empty($this->metaKeywords)) {
            Yii::$app->view->registerMetaTag([
                'name' => 'keywords',
                'content' => $this->metaKeywords,
            ]);
        }
    }
}