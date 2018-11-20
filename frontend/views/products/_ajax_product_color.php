<?php

/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 23.05.2017
 */

/* @var $colors common\models\CatalogColor[] */
/* @var $productVariants common\models\CatalogItemVariant[] */

if (!empty($productVariants)) {
    $i = 0;
    $sProdVarHtml = '';
    foreach ($productVariants as $pVar) {
        $sProdVarHtml .= '<a data-color-id="' . $pVar['color_id'] .
            '" data-img-src="' . $pVar['img_url'] .
            '" data-prod-id="' . $pVar['product_id'] .
            '" data-prod-var-id="' . $pVar['id'] .
            '" class="product-articul-' . $pVar['articul'] . ' prod-var-color prod-var-color-id-' . $pVar['color_id'] .
            '" title="' . $colors[ $pVar['color_id'] ]['title'] .
            '" href="#" data-toggle="tooltip" data-placement="top"><img src="/images/color/' . $pVar['color_id'] . '.png' .
            // '" style="width:32px;" alt="' . $colors[$i]['title'] . '"></a>';
            '" style="width:32px;"></a>';
        $i ++;
    }
    // $sProdVarHtml .= '<!-- colors: ' . print_r($colors, 1). ' -->';

    echo $sProdVarHtml;

$js = <<<EOFJS
    
    (function(){
    
        var countLoadBlocks;
        
        function removeLoader() {
            countLoadBlocks += 1;
            if (countLoadBlocks == 4) {
                $('body').addClass('closeLoad');
                
                setTimeout(function(){
                    $('body').removeClass('loading').removeClass('closeLoad');
                }, 400);
            }
        }
        
        function showProdLen2() {
            console.log('showProdLen2');
            
            /* var pLen = $('#prod-var-length2');
            if (pLen.length) {
                $(pLen).show();
            } else {                
                console.log('Error: #prod-var-length2 was not found!');
            } */
        }
        
        function loadProdVarLens(c, p) {            
            var pvl = $('#prod-var-length2');
             
            if (pvl.length) {
                $('#prod-var-length2').empty().load('{$urlPrefix}/products/load-product-lengths', {'{$csrfParam}': '{$csrfToken}', 'color_id': c, 'product_id': p}, showProdLen2);
            } else {
                console.log('Error: element with id #prod-var-length was not found on page');
            }
        }
        
        function loadPrVaPr(p) {
            $('#prod-var-price').empty().load('{$urlPrefix}/products/load-product-variant-price', 
            {'{$csrfParam}': '{$csrfToken}', 'id': p}, 
            removeLoader);    
        }
        
        function loadProdVaTi(p) {
            $('#item-variant-title').empty().load('{$urlPrefix}/products/load-product-variant-title', 
            {'{$csrfParam}': '{$csrfToken}', 'id': p},
            removeLoader);
        }
        
        function loadProdVaDescr(p) {
            console.log('loadProdVaDescr: ' + p);
            $('#prod-var-descr').load('{$urlPrefix}/products/load-product-variant-descr', 
            {'{$csrfParam}': '{$csrfToken}', 'id': p},
            removeLoader);
        }
        
        function loadProdVaSku(p) {
            $('#item-variant-articul').empty().load('{$urlPrefix}/products/load-product-variant-articul', 
            {'{$csrfParam}': '{$csrfToken}', 'id': p},
            removeLoader);
        }
        
        function loadProdVaSize(p) {
            var psc = $('#prod-size-container');
            if (psc.length) {
                $('#prod-size-container').empty().load('{$urlPrefix}/products/load-product-size', {'{$csrfParam}': '{$csrfToken}', 'id': p});
            } else {
                console.log('Error: no #prod-size-container exists');
                var pvd = $('#prod-var-descr');
                if (pvd.length) {
                    $(pvd).add('<div id="prod-size-container"></div>');
                    setTimeout(function(){ $('#prod-size-container').load('{$urlPrefix}/products/load-product-size', {'{$csrfParam}': '{$csrfToken}', 'id': p}); }, 17);                    
                } else {
                    var bpcr = $('.block-product_characteristics--right');
                    if (bpcr.length) {
                        $(bpcr).append('<div id="prod-size-container"></div>');
                        $('#prod-size-container').load('{$urlPrefix}/products/load-product-size', {'{$csrfParam}': '{$csrfToken}', 'id': p});                        
                    }                
                }            
            }
        }
        
        $('#prod-colors-cont a').eq(0).addClass('active');
        
        $('.prod-var-color').click(function(ev2){
            ev2.preventDefault();
            var th = $(this);
            
            var cId = $(th).attr('data-color-id');
            var pId = $(th).attr('data-prod-id');
            var pVid = $(th).attr('data-prod-var-id');
            var pImg = $(th).attr('data-img-src');
            
            /* console.log('Change color click data cId: ' + cId + '; pId: ' + pId + '; pVid: ' + pVid + '; pImg: ' + pImg); */
            
            countLoadBlocks = 0;
            
            if (pImg.length) {
                $('#main-product-img').attr('src', pImg);
            }
            
            $('body').addClass('loading');
            
            loadProdVarLens(cId, pId);
            loadProdVaSku(pVid);
            loadProdVaTi(pVid);
            loadProdVaDescr(pVid);
            loadPrVaPr(pVid);
            
            setTimeout(function(){ loadProdVaSize(pVid); }, 517);
            
            $('.prod-var-color.active').removeClass('active');
            $(this).addClass('active');
            $('[data-toggle="tooltip"]').tooltip();
            $('.imgs-prod-thumb__item-0 img').attr('src',  $('#main-product-img').attr('src'));
            
            return false;
        });
        
    })();
    
EOFJS;

    $this->registerJs($js);

}