<?php

/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 23.05.2017
 * Time: 15:04
 */

if (!empty($options)) {
    $nOpts = 0;
    $sOptHtml = '';
    foreach ($options as $optLen) {
        if (!empty($optLen['length'])) {
            $selected = '';
            if ($optLen['selected']) {
                $selected = ' selected';
            }
            $sOptHtml .= '<option' . $selected . ' value="' . $optLen['id'] . '">' . $optLen['length'] . ' ' . Yii::t('app', 'mm') . '</option>';
            $nOpts ++;
        }
    }
    $sOptHtml .= '';

    echo $sOptHtml;

    if ($nOpts == 0) {
$this->registerJs("
    
    $('#prod-var-length2-container').hide();
    
");
    } else {
$this->registerJs("
    
    $('#prod-var-length2-container').show();
    
");
    }
}
