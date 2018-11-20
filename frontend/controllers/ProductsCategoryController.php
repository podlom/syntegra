<?php

namespace frontend\controllers;


use Yii;
use yii\db\Expression;
use yii\helpers\Html;
use common\models\Meta;
use common\helpers\CatalogCategoryHelper;
use common\helpers\CatalogItemHelper;
use frontend\helpers\NavigationHelper;
use frontend\helpers\ProductCatalogHelper;
use common\models\Block;
use common\models\Page;
use common\models\Slide;
// use frontend\models\Menu;
use frontend\traits\Lang;
use frontend\traits\Menu;
use frontend\traits\SeoMetaParams;
use frontend\traits\Settings;
//


class ProductsCategoryController extends \yii\web\Controller
{
    /**
     * Use traits
     */
    use Lang, Menu, SeoMetaParams, Settings;

    public function actionView($slug)
    {

        $this->setLang();
        $this->setMenu();
        $this->setSeoMetaParams();
        $this->setSettings();
        
        $category = CatalogCategoryHelper::getCategoryBySlug($slug);
        $categories = CatalogCategoryHelper::getCategories();
        // Yii::info('Category id #' . $category->id);

        $productFilter1Options = ProductCatalogHelper::getProdVarFilterOpts($category->id);
        // Yii::info('Filer opt: ' . var_export($productFilter1Options, 1));

        $urlPrefix = NavigationHelper::getUrlPrefix();

        $scrfToken = Yii::$app->request->getCsrfToken();

        $blocks = Slide::find()
            ->where([
                'published' => 1,
                'category_id' => 2,
                'lang' => \Yii::$app->db->quoteSql($this->lang),
            ])->orderBy([
                'sort' => SORT_ASC,
            ])
            ->orderBy(new Expression('RAND()'))
            ->limit(3)
            ->all();

        $abPaId = 1;
        if ($this->lang == 'en') {
            $abPaId = 2;
        }
        $aboutUs = Page::findOne($abPaId);

        return $this->render('view', [
            'lang'                   =>  $this->lang,
            'meta'                   =>  $this->meta,
            'urlPrefix'              =>  $urlPrefix,
            'scrfToken'              =>  $scrfToken,
            'category'               =>  $category,
            'categories'             =>  $categories,
            'productFilter1Options'  =>  $productFilter1Options,
            'blocks'                 =>  $blocks,
            'aboutUs'                =>  $aboutUs,
        ]);
    }

}
