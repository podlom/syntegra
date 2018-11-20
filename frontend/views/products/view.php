<?php

use yii\widgets\Breadcrumbs;


/* @var $this yii\web\View */
/* @var $model common\models\CatalogItem */
/* @var $meta common\models\Meta */

$this->title = $model->sku . ' | ' . $model->category_id;
if (!empty($meta->title)) {
    $this->title = $meta->title;
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Catalog'), 'url' => [$urlPrefix . '/products/']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => [$urlPrefix . '/products-category/view/' . $category->slug]];
$this->params['breadcrumbs'][] = $model->sku;

?>

<!-- Section 10 -->
<section class="tpl__section section-10 cat-id-<?=$category->id;?>">
    <div class="section-inner">
        <div class="section-overlay"></div>
        <div class="section-title-page">
            <div class="block block-title">
                <div class="block-inner">
                    <h3><?=$category->name?></h3>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end Section 10 -->
<!-- Section 12 -->
<section class="tpl__section section-12">
    <div class="section-inner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-6 padding-right">
                    <div class="block block-image">
                        <div class="block-inner">
                            <div class="com__images com__image-resizable imgwr-in-prod">
                                <figure><img id="main-product-img" src="<?=$model->image?>" alt=""></figure>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (!empty($imgFiles)) {
                        echo $this->render('_img_gallery', [
                            'sGallery' => '',
                            'imgFiles' => $imgFiles,
                        ]);
                    }
                    ?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-6 prod-info-wrap">
                    <div class="block block-breadcrumbs">
                        <div class="block-inner">
                            <nav class="breadcrumbs">
                            <?php

                                /**
                                    <ul class="breadcrumb">
                                        <li><a href="/products/">Каталог</a></li>
                                        <li><a href="/products-category/view/<?=$category->slug?>"><?=$category->name?></a></li>
                                        <li><a><?=$model->sku?></a></li>
                                    </ul>
                                 */

                                echo Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], ]);

                            ?>
                            </nav>
                        </div>
                    </div>
                    <div class="block block-product_title">
                        <div class="block-inner">
                            <h3 id="item-variant-title"><?=$model->itemTitle?></h3><span id="item-variant-articul"><?=$defaultItemVar->articul?></span>
                        </div>
                    </div>
                    <div class="block block-product_characteristics">
                        <div class="block-inner">

                            <div class="block-product_characteristics--left">
                                <div class="com__images">
                                    <figure><img src="<?= $model->img_url ?>" alt=""></figure>
                                </div>
                            </div>

                            <div class="block-product_characteristics--right">
                                <div id="prod-var-descr">
                                    <?= $model->getItemDescr() ?>
                                </div>

                                <div id="prod-size-container">
                                    <?= $this->render('_ajax_product_size', ['urlPrefix' => $urlPrefix, 'model' => $model, 'dCpV' => $dCpV, 'csrfParam' => $csrfParam, 'csrfToken' => $csrfToken]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block block-product_color">
                        <div class="block-inner">
                            <p>Выберите цвет</p>

                            <div id="prod-colors-cont"></div>
                        </div>
                    </div>
                    <div class="block block-product_price">
                        <div class="block-inner">
                            <p><span id="prod-var-price"><?=$model->itemPrice?></span> грн</p>
                        </div>
                    </div>
                    <!-- div class="block block-product_button-buy">
                        <div class="block-inner">
                            <button class="btn btn-primary">КУПИТЬ</button>
                            <button class="btn btn-primary ua_24">КУПИТЬ на</button>
                        </div>
                    </div -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end Section 12 -->

<?php

echo $this->render('_video_consultant', [
    'urlPrefix' => $urlPrefix,
    'videoConsultant'  => $videoConsultant,
]);

echo $this->render('_related_products', [
    'urlPrefix' => $urlPrefix,
    'relatedProducts'  =>  $relatedProducts,
]);

$js = <<<EOJS1

    var pId = '{$model->id}';
    $('#prod-colors-cont').load('{$urlPrefix}/products/load-product-colors', {'{$csrfParam}': '{$csrfToken}', 'product_id': pId}, function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
    
EOJS1;

$this->registerJs($js);

if (!empty($blocks)) {

        echo $this->render('//slide/_product', [
            'blocks' => $blocks
        ]);

}
