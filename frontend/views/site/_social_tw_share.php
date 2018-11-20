<?php

use kartik\social\TwitterPlugin;


if (!empty($product_id)) {
    if (empty($baseUrl)) {
        $baseUrl = 'http://' . $_SERVER['HTTP_HOST'];
    }
    $productUrl = urlencode($baseUrl . '/blog/' . $slug);
    $shareText = urlencode('Syntegra');
    $productShareUrl = 'https://twitter.com/intent/tweet?text=' . $shareText . '&url=' . $productUrl;
    echo '<a href="' . $productShareUrl . '" target="_blank" ><div class="icon-twitter">twitter </div></a>';
} else {

}