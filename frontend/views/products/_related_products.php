<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 24.05.2017
 * Time: 13:18
 */

if (!empty($relatedProducts)) {

    $sRelProHtml = '';
    foreach ($relatedProducts as $rp1) {
        $sRelProHtml .= '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 padding-none">
                    <a class="item-tile" href="/products/view/' . $rp1->slug . '">
                        <div class="block block-product__content_item prod-tile">
                            <div class="block-inner">
                                <div class="block-product__content_item--image" style="background-image: url(' .  strtolower($rp1->image) . ')">
                                </div>
                                <div class="block-product__content_item--title">
                                    <h4>' . $rp1->title . '</h4>
                                    <h5>' . $rp1->sku . '</h5>
                                </div><div class="block-product__content_item--button">Подробнее</div>
                            </div>
                        </div>
                    </a>
                </div>';
    }
    $sRelProHtml .= '';

?>

<!-- Section 14 -->
<section class="tpl__section section-14">
    <div class="section-inner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <div class="block block-title">
                        <div class="block-inner">
                            <h3><?=Yii::t('app', 'Related products')?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid block-product__content">
            <div class="row" id="related-products-container">
                <?=$sRelProHtml?>
            </div>
        </div>
    </div>
</section>
<!-- end Section 14 -->

<?php

}