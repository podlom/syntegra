<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 22.05.2017
 */

/* @var $this yii\web\View */
/* @var $categories common\models\CatalogCategory[] */

if (!empty($categories)) {

    $catFiltersHtml = '<form id="cat_filter_f1">';
    foreach ($categories as $c1) {
        $catFiltersHtml .= '<div class="com__checkbox">
    <input type="checkbox" class="pro-cat-box" name="product_category_' . $c1['id'] . '" id="product_category_' . $c1['id'] . '"/>
    <label for="product_category_' . $c1['id'] . '">' . $c1['name'] . '</label>
</div>';
    }
    $catFiltersHtml .= '</form>';

    echo $catFiltersHtml;

$jsProCat = <<<EOJS
    
    $('.pro-cat-box').click(function(e1){
        var th = $(this);
        var idVa = $(th).attr('id');

        var chAc = $('#cat_filter_f1').find('input:checked');
        if (chAc.length) {
            for (var i=0; i<chAc.length; i++) {
                var cuId = $(chAc[i]).attr('id');
                if (cuId !== idVa) {
                    $(chAc[i]).prop('checked', false);
                } else {
                    console.log('Current checkbox id: ' + cuId + ' checked id: ' + idVa);
                    
                    $('#prod-item-cont').load('{$urlPrefix}/products/load-products', {'_csrf-frontend': '{$scrfToken}', 'category_id': cuId});
                    
                    $('#prod-opt-filt2-container').load('{$urlPrefix}/products/load-prod-filt1', {'_csrf-frontend': '{$scrfToken}', 'category_id': cuId}, function(){ $('.block-product__sorting_item').removeClass('hidden'); });                    
                    
                }
            }
        }
    });
    
EOJS;

$this->registerJs($jsProCat);


} else {
    echo '<!-- $categories is empty -->';
}
