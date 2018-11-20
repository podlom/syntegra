<?php

use kartik\social\GooglePlugin;

if (!empty($product_id)) {

    if (empty($baseUrl)) {
        $baseUrl = 'http://' . $_SERVER['HTTP_HOST'];
    }
    $productUrl = urlencode($baseUrl . '/blog/' . $slug);
    $shareText = urlencode('Syntegra');
    $productShareUrl = 'https://plus.google.com/share?hl=ru-RU&url=' . $productUrl;
    echo '<a href="' . $productShareUrl . '" target="_blank" >google</a>';
} else {

}