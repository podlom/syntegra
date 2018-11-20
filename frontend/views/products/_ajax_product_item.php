<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 22.05.2017
 * Time: 18:36
 */


/* @var $products common\models\CatalogItem[] */

$catItemsHtml = '';

if (!empty($products)) {

    foreach ($products as $pr1) {
        $catItemsHtml .= '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 padding-none">
                    <a class="item-tile" href="' . $urlPrefix . '/products/view/' . $pr1->slug . '">
                        <div class="block block-product__content_item prod-tile">
                            <div class="block-inner">
                                <div class="block-product__content_item--image" style="background-image: url(' .  strtolower($pr1->image) . ')">
                                </div>
                                <div class="block-product__content_item--title">
                                    <h4>' . $pr1->title . '</h4>
                                    <h5>' . $pr1->sku  . '</h5>
                                </div><div class="block-product__content_item--button">Подробнее</div>
                            </div>
                        </div>
                    </a>
                </div>';
    }
    $catItemsHtml .= '';


} else {

    $catItemsHtml = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding-none">' .
            Yii::t('app', 'Products with selected search criteria was not found') .
        '</div>';

}

echo $catItemsHtml;