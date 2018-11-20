<?php

/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 19.12.2017
 * Time: 11:38
 */

?>
<div class="block-product_characteristics--right_dimensions">
    <p>Размеры</p>
    <div id="prod-var-length2-container" class="block-product_characteristics--right_dimensions-item"><span>Длина</span>
        <select id="prod-var-length2" name="length" class="select">
        </select>
    </div>
    <?php if (intval($model->width) > 0) { ?><div class="block-product_characteristics--right_dimensions-item"><span>Ширина</span><span><?= $model->width ?> <?= Yii::t('app', 'mm') ?></span></div><?php } ?>
    <?php if (intval($model->height) > 0) { ?><div class="block-product_characteristics--right_dimensions-item"><span>Высота</span><span><?= $model->height ?> <?= Yii::t('app', 'mm') ?></span></div><?php } ?>
</div>
<?php

$prLeJs = <<<EOPLJS

    (function(){

        var countLoadBlocks;
            
        function removeLoader() {
            countLoadBlocks += 1;
            
            if (countLoadBlocks == 3) {
                setTimeout(function() {
                    $('body').addClass('closeLoad');
                }, 300);
                setTimeout(function() {
                    $('body').removeClass('loading').removeClass('closeLoad');
                }, 800);
            }
        }
        
        function showProdLen() {
            console.log('showProdLen');
        }
    
        function loadDefProdVarLengs(c, p, t) {
            if (typeof t != "undefined") {
                $('#prod-var-length2').empty().load('{$urlPrefix}/products/load-product-lengths', {'{$csrfParam}': '{$csrfToken}', 'color_id': c, 'product_id': p, 'len_txt': t}, showProdLen);            
            } else if (c.length && p.length) {
                $('#prod-var-length2').empty().load('{$urlPrefix}/products/load-product-lengths', {'{$csrfParam}': '{$csrfToken}', 'color_id': c, 'product_id': p}, showProdLen);            
            } 
        }
        
        function loadProdVarPrice(p) {
            $('#prod-var-price').empty().load('{$urlPrefix}/products/load-product-variant-price', {'{$csrfParam}': '{$csrfToken}', 'id': p}, removeLoader);    
        }
        
        function loadProdVaSku(p) {
            $('#item-variant-articul').empty().load('{$urlPrefix}/products/load-product-variant-articul', {'{$csrfParam}': '{$csrfToken}', 'id': p}, removeLoader);
        }
        
        function loadPrVarTitle(p) {
            $('#item-variant-title').empty().load('{$urlPrefix}/products/load-product-variant-title', {'{$csrfParam}': '{$csrfToken}', 'id': p}, removeLoader);
        }
        
        function loadPrVarDescr(p) {
            $('#prod-var-descr').load('{$urlPrefix}/products/load-product-variant-descr', {'{$csrfParam}': '{$csrfToken}', 'id': p}, removeLoader);
        }
        
        function loadProdVaSize2(p) {
            var psc = $('#prod-size-container');
            if (psc.length) {
                $('#prod-size-container').load('{$urlPrefix}/products/load-product-size', {'{$csrfParam}': '{$csrfToken}', 'id': p});
            } else {
                console.log('Error: no #prod-size-container exists');
                var pvd = $('#prod-var-descr');
                if (pvd.length) {
                
                    $(pvd).add('<div id="prod-size-container"></div>');
                    setTimeout(function(){
                        var psc2 = $('#prod-size-container');
                        if (psc2.length) {
                            console.log('Added #prod-size-container');
                            $('#prod-size-container').empty().load('{$urlPrefix}/products/load-product-size', {'{$csrfParam}': '{$csrfToken}', 'id': p});
                        } else {
                            console.log('Error 2 no #prod-size-container exists!');
                        }
                    }, 123);
                } else {
                    console.log('Error: no #prod-var-descr exists');
                }           
            }
        }
    
        var vId = "{$dCpV['id']}";
        loadProdVarPrice(vId);
        
        var dCId = "{$dCpV['color_id']}";
        var dPId = "{$dCpV['product_id']}";
        var dLen = "{$dCpV['length']}";
        loadDefProdVarLengs(dCId, dPId, dLen);
        
        $('#prod-var-length2').change(function(eS){
            eS.stopPropagation();
            
            countLoadBlocks = 0;
            var selLen = $('#prod-var-length2 option:selected').val();
            var selTxt = $('#prod-var-length2 option:selected').text();
            
            $('body').addClass('loading');
            
            loadDefProdVarLengs(dCId, selLen, selTxt);
            
            loadProdVaSku(selLen);
            loadPrVarTitle(selLen);
            loadPrVarDescr(selLen);
            loadProdVarPrice(selLen);
            
            setTimeout(function(){ loadProdVaSize2(selLen); }, 127);
        });
    
    })();

EOPLJS;

$this->registerJs($prLeJs);
