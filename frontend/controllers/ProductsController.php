<?php

namespace frontend\controllers;


use Yii;
use yii\db\Expression;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Application;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use common\helpers\CatalogCategoryHelper;
use common\helpers\CatalogItemHelper;
use common\models\Block;
use common\models\CatalogItem;
use common\models\CatalogItemVariant;
use common\models\CatalogColor;
use common\models\CatalogCategory;
use common\models\Meta;
use common\models\Slide;
use frontend\helpers\NavigationHelper;
use frontend\helpers\ProductCatalogHelper;
// use frontend\models\Menu;
use frontend\traits\Lang;
use frontend\traits\Menu;
use frontend\traits\SeoMetaParams;
use frontend\traits\Settings;
//


class ProductsController extends Controller
{
    /**
     * Use traits
     */
    use Lang, Menu, SeoMetaParams, Settings;

    public function actionIndex()
    {
        /*
        $lang = Yii::$app->view->params['langActive'] = Yii::$app->view->params['lang'] = Yii::$app->language;
        Yii::$app->view->params['menu1'] = Menu::getTopMenu1(Yii::$app->language);
        Yii::$app->view->params['menu3'] = Menu::getBottomMenu1(Yii::$app->language);

        $reqUri = Yii::$app->request->getPathInfo();
        if (empty($reqUri)) {
            if (Yii::$app->language !== 'ru') {
                $reqUri .= Yii::$app->language;
            }
        }
        Yii::$app->view->params['requestUri'] = $reqUri;
        $meta = Meta::findOneByUrl(Yii::$app->view->params['requestUri']);
        Yii::$app->view->params['meta_image'] = $meta->meta_image;
        Yii::$app->view->params['og_image'] = $meta->og_image;
        Yii::$app->view->params['og_title'] = $meta->og_title;
        Yii::$app->view->params['og_description'] = $meta->og_description;

        $metaDescription = Html::encode($meta->description);
        if (!empty($metaDescription)) {
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => $metaDescription,
            ]);
        }

        $metaKeywords = Html::encode($meta->keywords);
        if (!empty($metaKeywords)) {
            Yii::$app->view->registerMetaTag([
                'name' => 'keywords',
                'content' => $metaKeywords,
            ]);
        }
        */

        $this->setLang();
        $this->setMenu();
        $this->setSeoMetaParams();
        $this->setSettings();

        $categories = CatalogCategoryHelper::getCategories();
        // Yii::info('$categories[0]->name: ' . var_export($categories[0]->name, 1));

        $productFilter1Options = [];

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

        return $this->render('index', [
            'lang'                   =>  $this->lang,
            'meta'                   =>  $this->meta,
            'urlPrefix'              =>  $urlPrefix,
            'this'                   =>  $this,
            'scrfToken'              =>  $scrfToken,
            'categories'             =>  $categories,
            'productFilter1Options'  =>  $productFilter1Options,
            'blocks'                 =>  $blocks,
        ]);
    }

    public function actionLoadProdFilt1()
    {
        if (Yii::$app->request->isAjax) {
            $postData = Yii::$app->request->post();
            // Yii::info('Post data: ' . var_export($postData, 1));

            $catId = intval(substr($postData['category_id'], 17));
            $productFilter1Options = ProductCatalogHelper::getProdVarFilterOpts($catId);
            // Yii::info('Filer opt: ' . var_export($productFilter1Options, 1));

            $urlPrefix = NavigationHelper::getUrlPrefix();

            // $scrfToken = Yii::$app->request->getCsrfToken();
            $csrfParam = Yii::$app->request->csrfParam;
            $csrfToken = Yii::$app->request->csrfToken;

            return $this->renderAjax('_products_filter1', [
                'urlPrefix'              =>  $urlPrefix,
                'csrfParam'              =>  $csrfParam,
                'csrfToken'              =>  $csrfToken,
                'productFilter1Options'  =>  $productFilter1Options,
            ]);
        }
    }

    public function actionLoadProducts()
    {
        if (Yii::$app->request->isAjax) {
            $postData = Yii::$app->request->post();
            Yii::info('Post data: ' . var_export($postData, 1));

            $catId = intval(substr($postData['category_id'], 17));
            // Yii::info('Category id: ' . var_export($catId, 1));

            /*  'prod_filter_id' => 'sub_cat[1][2]', */
            if (!empty($postData['prod_filter_id'])) {
                // Yii::info('SubCategories: ' . var_export($postData['prod_filter_id'], 1));
                if (is_array($postData['prod_filter_id'])) {
                    // multiple subcategories
                    $products = ProductCatalogHelper::getProdBySubcat($postData['prod_filter_id'], $catId);
                    // Yii::info('prods: ' . print_r($products, 1));
                }
            } else {
                $products = ProductCatalogHelper::getProdByCat($catId);
                // Yii::info('prod[0]->id: ' . var_export($products[0]->id, 1));
            }

            $urlPrefix = NavigationHelper::getUrlPrefix();

            return $this->renderAjax('_ajax_product_item.php', [
                'urlPrefix'  =>  $urlPrefix,
                'products'   =>  $products,
            ]);
        }
    }

    public function actionLoadProductColors()
    {
        if (Yii::$app->request->isAjax) {
            $postData = Yii::$app->request->post();
            // Yii::info('Post data: ' . var_export($postData, 1));

            $productId = intval($postData['product_id']);

            $colorId = intval($postData['color_id']);

            $prodVariants = ProductCatalogHelper::getCatalogItemVariants($productId);
            // Yii::info('Prod variants: ' . var_export($prodVariants, 1));

            $filterColorId = $allColors = [];
            /* if (!empty($prodVariants)) {
                foreach ($prodVariants as $pC3) {
                    $filterColorId[] = $pC3['color_id'];
                }
            } */
            // Yii::info('Filtered color ids: ' . var_export($filterColorId, 1));
            $lang = Yii::$app->language;
            $sql = "SELECT * FROM `catalog_color` WHERE (`id` IN (SELECT color_id FROM `catalog_item_variant` WHERE ((`published`=1) AND (`lang`='{$lang}')) AND (`product_id`='{$productId}') GROUP BY `color_id` ORDER BY `sort`)) AND (`lang`='{$lang}');";
            $colorTextures = CatalogColor::findBySql($sql)
                ->asArray()
                ->all();
            if (!empty($colorTextures)) {
                foreach ($colorTextures as $cT) {
                    if (!in_array($cT['id'], $allColors)) {
                        $allColors[$cT['id']] = $cT;
                    }
                    if (!in_array($cT['id'], $filterColorId)) {
                        $filterColorId[] = $cT['id'];
                    }
                }
            }
            // Yii::info('Found textures: ' . var_export($colorTextures, 1));

            $urlPrefix = NavigationHelper::getUrlPrefix();

            $csrfParam = Yii::$app->request->csrfParam;
            $csrfToken = Yii::$app->request->csrfToken;


            return $this->renderAjax('_ajax_product_color.php', [
                'urlPrefix'        => $urlPrefix,
                'productVariants'  => $prodVariants,
                'colorIds'         => $filterColorId,
                // 'colors'        => $colorTextures,
                'colors'           => $allColors,
                'colorId'          => $colorId,
                'csrfParam'        => $csrfParam,
                'csrfToken'        => $csrfToken,
            ]);
        }
    }

    public function actionLoadProductLengths()
    {
        if (Yii::$app->request->isAjax) {
            $postData = Yii::$app->request->post();
            Yii::info('Got POST data: ' . var_export($postData, 1));

            $productId = intval($postData['product_id']);
            $colorId = intval($postData['color_id']);

            $defaultLen = 900.00;
            if (isset($postData['len_txt'])) {
                $lenTxt = $postData['len_txt'];
                $p = strpos($postData['len_txt'], ' ');
                if ($p !== false) {
                    $aL = explode(' ', $postData['len_txt']);
                    $defaultLen = $aL[0];
                }
            }
            Yii::info('$defaultLen: ' . var_export($defaultLen, 1));

            $lang = Yii::$app->language;
            $prodLengths = CatalogItemVariant::find()
                ->where(['published' => 1, 'lang' => $lang])
                ->andWhere(['product_id' => $productId, 'color_id' => $colorId])
                ->orderBy(['sort' => SORT_ASC])
                ->asArray()
                ->all();
            Yii::info('Found prod lengths: ' . var_export($prodLengths, 1));

            if (!empty($prodLengths)) {
                foreach ($prodLengths as $kPl => &$vPl) {
                    if ($vPl['color_id'] == $colorId && $vPl['length'] == $defaultLen) {
                        $vPl['selected'] = 1;
                    }
                }

                return $this->renderAjax('_option_select_length', [
                    'options' => $prodLengths,
                ]);
            }
        }
    }

    public function actionLoadProductVariantPrice()
    {
        if (Yii::$app->request->isAjax) {
            $postData = Yii::$app->request->post();
            // Yii::info('Post data: ' . var_export($postData, 1));

            $id = intval($postData['id']);
            $price = 0.00;

            $prodPrice = CatalogItemVariant::find()
                ->select(['price'])
                ->where(['published' => 1])
                ->andWhere(['id' => $id])
                ->asArray()
                ->one();
            // Yii::info('Prod var price: ' . var_export($prodPrice, 1));

            if (isset($prodPrice['price'])) {
                $price = $prodPrice['price'];
            }
            return $price;
        }
    }

    public function actionLoadProductVariantArticul()
    {
        if (Yii::$app->request->isAjax) {
            $postData = Yii::$app->request->post();

            $id = intval($postData['id']);

            $prodVar = CatalogItemVariant::find()
                ->select(['articul'])
                ->where(['published' => 1])
                ->andWhere(['id' => $id])
                ->asArray()
                ->one();

            if (isset($prodVar['articul'])) {
                return $prodVar['articul'];
            }
        }
    }

    public function actionLoadProductVariantTitle()
    {
        if (Yii::$app->request->isAjax) {
            $postData = Yii::$app->request->post();
            // Yii::info('Post data: ' . var_export($postData, 1));

            $id = intval($postData['id']);

            $prodVar = CatalogItemVariant::find()
                ->select(['title'])
                ->where(['published' => 1])
                ->andWhere(['id' => $id])
                ->asArray()
                ->one();
            // Yii::info('Prod var title: ' . var_export($prodVar, 1));

            if (isset($prodVar['title'])) {
                return $prodVar['title'];
            }
        }
    }

    public function actionLoadProductVariantDescr()
    {
        if (Yii::$app->request->isAjax) {
            $postData = Yii::$app->request->post();
            // Yii::info('Post data: ' . var_export($postData, 1));

            $id = intval($postData['id']);

            $prodVar = CatalogItemVariant::find()
                ->select(['descr'])
                ->where(['published' => 1])
                ->andWhere(['id' => $id])
                ->asArray()
                ->one();
            // Yii::info('Prod var title: ' . var_export($prodVar, 1));

            if (isset($prodVar['descr'])) {
                return $prodVar['descr'];
            }
        }
    }

    public function actionLoadProductSize()
    {
        if (Yii::$app->request->isAjax) {
            $postData = Yii::$app->request->post();
            /* Yii::info('Got POST data: ' . var_export($postData, 1)); */

            $productId = intval($postData['id']);

            $lang = Yii::$app->language;
            $prodVar = CatalogItemVariant::find()
                ->where(['id' => $productId, 'published' => 1, 'lang' => $lang])
                ->one();

            if (!empty($prodVar)) {
                $model = CatalogItem::findOne(['id' => $prodVar->product_id]);
                /* Yii::info('Found $model: ' . print_r($model, 1)); */

                $urlPrefix = NavigationHelper::getUrlPrefix();

                $csrfParam = Yii::$app->request->csrfParam;
                $scrfToken = Yii::$app->request->csrfToken;

                if (!empty($model)) {
                    $dCpV = $model->getDefaultCatalogItemVariant();

                    return $this->renderAjax('_ajax_product_size', [
                        'model'     => $model,
                        'dCpV'      => $dCpV,
                        'urlPrefix' => $urlPrefix,
                        'csrfParam' => $csrfParam,
                        'csrfToken' => $scrfToken,
                    ]);
                }
            }
        }
    }

    public function actionView($slug)
    {
        /*
        $lang = Yii::$app->view->params['langActive'] = Yii::$app->view->params['lang'] = Yii::$app->language;
        Yii::$app->view->params['menu1'] = Menu::getTopMenu1(Yii::$app->language);
        Yii::$app->view->params['menu3'] = Menu::getBottomMenu1(Yii::$app->language);

        $reqUri = Yii::$app->request->getPathInfo();
        if (empty($reqUri)) {
            if (Yii::$app->language !== 'ru') {
                $reqUri .= Yii::$app->language;
            }
        }
        Yii::$app->view->params['requestUri'] = $reqUri;
        $meta = Meta::findOneByUrl(Yii::$app->view->params['requestUri']);
        // Yii::info('Meta: ' . print_r($meta, 1));
        Yii::$app->view->params['meta_image'] = Html::encode($meta->meta_image);
        Yii::$app->view->params['og_image'] = Html::encode($meta->og_image);
        Yii::$app->view->params['og_title'] = Html::encode($meta->og_title);
        Yii::$app->view->params['og_description'] = Html::encode($meta->og_description);

        $metaDescription = Html::encode($meta->description);
        if (!empty($metaDescription)) {
            Yii::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => $metaDescription,
            ]);
        }

        $metaKeywords = Html::encode($meta->keywords);
        if (!empty($metaKeywords)) {
            Yii::$app->view->registerMetaTag([
                'name' => 'keywords',
                'content' => $metaKeywords,
            ]);
        }

        */

        $this->setLang();
        $this->setMenu();
        $this->setSeoMetaParams();
        $this->setSettings();

        $model = ProductCatalogHelper::getCatalogItemBySlug($slug);
        $defaultItemVariant = ProductCatalogHelper::getDefaultItemVariant($model->id);
        $checkImg = Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . $model->img_url;
        if (!file_exists($checkImg)) {
            // Yii::info('File: ' . $checkImg . ' does not exists.');
            $model->img_url = '/images/product/_default.jpg';
            // Yii::info('Changed to default image file: ' . $model->img_url);
        }

        $category = ProductCatalogHelper::getCatalogCategory($model->category_id);

        $relatedProducts = ProductCatalogHelper::getRelatedProducts($model->category_id, $model->id);

        $videoConsultant = ProductCatalogHelper::getVideoConsultant($model->category_id);

        if (empty($model)) {
            throw new NotFoundHttpException;
        }

        $catalogItem = CatalogItem::findOne(['id' => $model->id]);
        if (!empty($catalogItem)) {
            $dCpV = $catalogItem->getDefaultCatalogItemVariant();
        }

        $urlPrefix = NavigationHelper::getUrlPrefix();

        $csrfParam = Yii::$app->request->csrfParam;
        $scrfToken = Yii::$app->request->csrfToken;

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

        $imgFiles = array_merge([$defaultItemVariant->img_url], ProductCatalogHelper::getProductItemGallery($model->id));
        // Yii::warning('$imgFiles: ' . print_r($imgFiles, 1), __METHOD__);

        return $this->render('view', [
            'meta'             =>  $this->meta,
            'urlPrefix'        =>  $urlPrefix,
            'csrfParam'        =>  $csrfParam,
            'csrfToken'        =>  $scrfToken,
            'model'            =>  $model,
            'dCpV'             =>  $dCpV,
            'category'         =>  $category,
            'relatedProducts'  =>  $relatedProducts,
            'videoConsultant'  =>  $videoConsultant,
            'blocks'           =>  $blocks,
            'defaultItemVar'   =>  $defaultItemVariant,
            'imgFiles'         =>  $imgFiles,
        ]);
    }

    public function actionViewImg($img_url)
    {
        $displImg = $checkImg = Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . $img_url;
        if (file_exists($checkImg)) {
            Yii::info('File: ' . $checkImg . ' exists');
        } else {
            $displImg = Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'images/product/_default.jpg';
            Yii::info('File: ' . $checkImg . ' does not exists. Using default image file: ' . $displImg);
        }
        $response = Yii::$app->getResponse();
        $response->headers->set('Content-Type', 'image/jpeg');
        $response->format = Response::FORMAT_RAW;
        if ( !is_resource($response->stream = fopen($displImg, 'r')) ) {
            throw new \yii\web\ServerErrorHttpException('file access failed: permission deny');
        }
        return $response->send();
    }
}
