<?php

use kartik\social\FacebookPlugin;

if (!empty($product_id)) {

    if (empty($baseUrl)) {
        $baseUrl = 'http://' . $_SERVER['HTTP_HOST'];
    }
    $productUrl = urlencode($baseUrl . '/blog/' . $slug);
    $shareText = urlencode('Syntegra');
    $productShareUrl = 'https://www.facebook.com/sharer/sharer.php?u=' . $productUrl . '&t=' . $shareText;
    echo '<a href="' . $productShareUrl . '" target="_blank" >facebook</a>';

} else {

}
