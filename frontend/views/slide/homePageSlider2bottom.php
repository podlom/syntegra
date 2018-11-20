<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 18.05.2017
 * Time: 11:25
 */

use yii\helpers\Url;
use yii\helpers\Html;


/** @var $slides common\models\Slide[] */

if (!empty($slides)) {
    $j = 0;
    $iClass21 = $iHtml21 = $sClass21 = $sHtml21 = '';

    foreach ($slides as $s2t) {
        if ($j == 0) {
            $iClass21 = ' class="active"';
            $sClass21 = 'item active';
        } else {
            $iClass21 = '';
            $sClass21 = 'item';
        }
        if(strlen($s2t->img_url2) < 3){
            $s2t->img_url2 = '/images/image_section_1.jpg';
        }
        // carousel indicators
        $iHtml21 .= '<li ' . $iClass21 . ' data-target="#carousel_slider-product-text" data-slide-to="' . $j . '"></li>';
        $sHtml21 .= '<div class="' . $sClass21 . '">
    <div class="block block-cat_decor">
        <div class="block-inner">
            <div class="block-cat_decor--left">
                <div class="com__images">
                    <figure class="imgitexslbot" style="background-image: url( ' . $s2t->img_url2 . ' )"></figure>
                </div>
            </div>
            <div class="block-cat_decor--right">
                <p>
                ' . strip_tags($s2t->text) . '
                </p>
            </div>
        </div>
    </div>
</div>';
        $j ++;
    }

    $sHtml2Bottom = <<<EOS2

<!-- Section 2 -->
<section class="tpl__section section-2">
    <div class="section-inner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-0 col-sm-0 col-md-4 col-lg-4"></div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="carousel carousel_slider slide" id="carousel_slider-product-text">
                      <ol class="carousel-indicators">
                        {$iHtml21}
                      </ol>
                    <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            {$sHtml21}                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end Section 2 -->

EOS2;

echo $sHtml2Bottom;

$this->registerJs("


    
   

", \yii\web\View::POS_END);

}
