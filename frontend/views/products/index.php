<?php

/* @var $this yii\web\View */
/* @var $categories common\models\CatalogCategory[] */

?>
<!-- Section 10 -->
<section class="tpl__section section-10 wth-video">
    <?php require_once (__DIR__ . '/../inc/cat-bg-video.php');?>
    <div class="section-inner">

        <div class="section-overlay"></div>
        <div class="section-title-page">
            <div class="block block-title">
                <div class="block-inner">
                    <h3>Каталог</h3>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end Section 10 -->
<!-- Section 11 -->
<section class="tpl__section section-11">
    <div class="section-inner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 padding-none">
                    <div class="block block-product__sorting">
                        <div class="block-product__sorting_botton collapsed" data-toggle="collapse" data-target="#collapse-sorting" aria-expanded="false">
                            <p>Фильтр продукции</p>
                        </div>
                        <div class="block-inner collapse" id="collapse-sorting">
                            <div class="block-product__sorting_item">
                                <div class="block-product__sorting_item--title">
                                    <h5><?=Yii::t('app', 'Category')?></h5>
                                </div>
                                <div class="block-product__sorting_item--options">

<?php

    echo $this->render('_categories_filter', [
        'lang'       => $lang,
        'scrfToken'  => $scrfToken,
        'urlPrefix'  => $urlPrefix,
        'categories' => $categories,
    ]);

?>
                                </div>
                            </div>

                            <div id="prod-opt-filt2-container">
                                <?php

                                echo $this->render('//products/_products_filter1', [
                                    'urlPrefix'              => $urlPrefix,
                                    'scrfToken'              => $scrfToken,
                                    'productFilter1Options'  => $productFilter1Options,
                                ]);

                                ?>
                            </div>

                            <!-- div class="block-product__sorting_item">
                                <div class="block-product__sorting_item--title">
                                    <h5>Параметр</h5>
                                </div>
                                <div class="block-product__sorting_item--options">
                                    <input id="product_options_range" type="text"/>
                                </div>
                            </div -->
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 padding-none">
                    <div class="container-fluid block-product__content">
                        <div id="prod-item-cont" class="row">

<?php

    $prCatHtml = '';
    if (!empty($categories)) {
        foreach ($categories as $cat1) {
            $prCatHtml .= '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 padding-none">
                        <a class="item-tile" href="' . $urlPrefix . '/products-category/view/' . $cat1['slug'] . '">
                            <div class="block block-product__content_item">
                                <div class="block-inner">
                                    <div class="block-product__content_item--image" style="background-image: url(' . strtolower($cat1['img_url']) . ')">
                                    </div>
                                    <div class="block-product__content_item--title">
                                        <h5>' . $cat1['name']  . '</h5>
                                    </div><div class="block-product__content_item--button">Подробнее</div>
                                </div>
                            </div>
                        </a>
                    </div>';
        }
    }

    echo $prCatHtml;

?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end Section 11 -->

<!-- Section 4 -->
<section class="tpl__section section-4">
    <video autoplay muted loop="loop">
        <source src="/video/bg/aboutbg.mp4" type="video/mp4">
    </video>
    <div class="section-inner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-0 col-sm-6 col-md-5 col-lg-4">
                    <div class="block block-about_us">
                        <div class="block-inner">
                            <h1>О нас</h1><a class="btn btn-primary btn-primary-border" href="/site/about">Подробнее</a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-7 col-lg-8"></div>
            </div>
        </div>
    </div>
</section>
<!-- end Section 4 -->

<?php

/* echo $this->render('//site/_contact-request', [
    'lang'      => $lang,
    'urlPrefix' => $urlPrefix,
]); */

/*
if (!empty($blocks)) {
    $zb = 1;
    foreach ($blocks as $block) {
        echo $this->render('_block' . $zb, ['block' => $block]);
        $zb ++;
        if ($zb > 3) {
            $zb = 1;
        }
    }
}
*/

if (!empty($blocks)) {

    echo $this->render('//slide/_product', [
        'blocks' => $blocks
    ]);

}