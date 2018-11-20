<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 24.05.2017
 */

/**
 * filter_id = subcategory_id
 * id = catalog_subcategory{$subcategory_id}
 * category_id = product category_id
 */

if (!empty($productFilter1Options)) {

    $prCatId = 0;
    $sPrOptHtml = '<div id="prod-opt-container">';
    foreach ($productFilter1Options as $po) {
        $sPrOptHtml .= '<div class="com__checkbox">
                <input type="checkbox" id="sub_cat[][' . $po['filter_id'] . '][' . $po['id'] . ']" name="sub_cat[][' . $po['filter_id'] . '][' . $po['id'] . ']">
                <label for="sub_cat[][' . $po['filter_id'] . '][' . $po['id'] . ']">' . $po['title'] . '</label>
            </div>';
        $prCatId = $po['category_id'];
    }
    $sPrOptHtml .= '<input type="hidden" id="product_category_id" name="product_category_id" value="product_category_' . $prCatId . '"></div>';

?>


    <div class="block-product__sorting_item hidden">
        <div class="block-product__sorting_item--title">
            <h5>Параметр</h5>
        </div>
        <div class="block-product__sorting_item--options">
            <form id="prod_filter_f2">
                <?=$sPrOptHtml?>
            </form>
        </div>
    </div>


<?php

$jsProdFilter = <<<EOJS
    
    function getChecked()
    {
        var selected = [];
        $('#prod-opt-container input:checked').each(function() {
            selected.push($(this).attr('name'));
        });
        return selected;
    }
    
    $('[name^="sub_cat\[\]"]').click(function(e1){
        var th = $(this);
        
        // var idVa = $(th).attr('id');
        // var idVa = $("#prod-opt-container").children("input:checked");
        /*var idVa = $("#prod-opt-container").children("input:checked").map(function() {
            return this.name;
        });*/
        var idVa = getChecked();
        console.log('Product category filter click: ' + idVa);
        
        var prCaId = $('#product_category_id').val();
        console.log('Product category id: ' + prCaId);
        
        $('#prod-item-cont').load('{$urlPrefix}/products/load-products', {'{$csrfParam}': '{$csrfToken}', 'category_id': prCaId, 'prod_filter_id': idVa});
    });
    
EOJS;

    $this->registerJs($jsProdFilter);

} else {
    echo '<!-- No product filters was found -->';
}