<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 18.05.2017
 */

use yii\helpers\Url;
use yii\helpers\Html;


/** @var $slides common\models\Slide[] */

if (!empty($slides)) {
    $k = 0;
    $iClass22 = $iHtml22 = $sClass22 = $sHtml22 = '';

    foreach ($slides as $s2b) {
        if ($k == 0) {
            $iClass22 = ' class="active"';
            $sClass22 = 'item active';
        } else {
            $iClass22 = '';
            $sClass22 = 'item';
        }
        $a1 = $a2 = '';
        if (!empty($s2b->href)) {
            $a1 = '<a href="' . $s2b->href . '">';
            $a2 = '</a>';
        }
        // carousel indicators
        $iHtml22 .= '<li ' . $iClass22 . ' data-target="#carousel_slider" data-slide-to="' . $k . '">';
        $sHtml22 .= '<div class="' . $sClass22 . '">
                    <div class="block block-floor_decor">
                      <div class="block-inner">
                        <div class="block-floor_decor--left">
                          <h3>' . $a1 . $s2b->title . $a2 . '</h3>
                        </div>
                        <div class="block-floor_decor--right">
                            <div class="com__images com__image-resizable">
                              <figure>' . $a1 . '<img src="' . $s2b->img_url . '" alt="">' . $a2 . '</figure>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>';
        $k ++;
    }


$sliderTopHtml = <<<EOST

    <div class="carousel slide" id="carousel_slider">
         <ol class="carousel-indicators">
            {$iHtml22}
          </ol>
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            {$sHtml22}  
        </div>
    </div>

EOST;

echo $sliderTopHtml;

}
