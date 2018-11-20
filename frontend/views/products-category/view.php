<?php

/* @var $this yii\web\View */
/* @var $category common\models\CatalogCategory */
/* @var $products common\models\CatalogItem[] */


?>
<!-- Section 10 -->
<section class="tpl__section section-10 wth-video">
    <?php require_once (__DIR__ . '/../inc/cat-bg-video.php');?>
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

                                    echo $this->render('//products/_categories_filter', [
                                        'urlPrefix'   =>  $urlPrefix,
                                        'scrfToken'   =>  $scrfToken,
                                        'categories'  =>  $categories,
                                    ]);

                                    ?>
                                </div>
                            </div>

                            <div id="prod-opt-filt2-container">
                            <?php

                            echo $this->render('//products/_products_filter1', [
                                'urlPrefix'              =>  $urlPrefix,
                                'scrfToken'              =>  $scrfToken,
                                'productFilter1Options'  =>  $productFilter1Options,
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php

$jsCl = <<<EOJSCL
    $(document).ready(function(){
    
        var catCheckbox = $('#product_category_{$category->id}');
        
        if(catCheckbox.is(':checked')){
           catCheckbox.prop('checked', false);
        }
     
        catCheckbox.trigger('click');      
        
        $('.block-product__sorting_item').removeClass('hidden');
    
    });

EOJSCL;

$this->registerJs($jsCl);

?>
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
    'lang'       =>  $lang,
    'urlPrefix'  =>  $urlPrefix,
]); */

/* if (!empty($textBlocks)) {
    foreach ($textBlocks as $block) {
        echo $this->render('../products/_category_block', ['block' => $block]);
    }
} */

/* if (!empty($blocks)) {
    $zb = 1;
    foreach ($blocks as $block) {
        echo $this->render('../products/_block' . $zb, ['block' => $block]);
        $zb ++;
        if ($zb > 3) {
            $zb = 1;
        }
    }
} */

if (!empty($blocks)) {

    echo $this->render('//slide/_product', [
        'blocks' => $blocks
    ]);

}
