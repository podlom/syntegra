<?php

use yii\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $partners common\models\Partner[] */

if (!empty($partners)) {
    $partnersHtml = '<!-- Partners Section -->
<div class="row">
    <div style="" class="col-lg-12">
        <h2 class="page-header text-center partnHdr">
            ' . Yii::t('app', 'Partners') . '
        </h2>
    </div>
</div>

';
    echo $partnersHtml;

    $sliderId = 'csPartnersCarousel';
    $slidesNav = '<ol class="carousel-indicators">';

    $cntSlides = count($partners);
    for ($i = 0; $i < $cntSlides; $i++) {
        if ($i == 0) {
            $class = ' class="active"';
        } else {
            $class = '';
        }
        $slidesNav .= '<li data-target="#' . $sliderId . '" data-slide-to="' . $i . '"' . $class . '></li>';
    }
    $slidesNav .= '</ol>';

    $slidesHtml = '<div class="carousel-inner">';
    foreach ($partners as $i => $part1) {
        $part1->logo_url = Url::to(Yii::getAlias('@web') . $part1->logo_url);
        $part1->title = Html::encode($part1->title);
        if ($i == 1) {
            $class = 'item active';
        } else {
            $class = 'item';
        }
        $slidesHtml .= '<div class="' . $class . '">
    <img src="' . $part1->logo_url . '" style="width:250px;margin:0 auto;" alt="' . $part1->title . '" title="' . $part1->title . '">
</div>';
    }
    $slidesHtml .= '</div>';

    $carouselSliderHtml = '<div class="row-fluid">
    <div class="span_998">
        <div id="' . $sliderId . '" class="carousel slide">
            ' . $slidesNav . '
            ' . $slidesHtml . '
            <a class="left carousel-control" href="#' . $sliderId . '" data-slide="prev">
                <span class="icon-prev"></span>
            </a>
            <a class="right carousel-control" href="#' . $sliderId . '" data-slide="next">
                <span class="icon-next"></span>
            </a>
        </div>
    </div>
</div>';
    echo $carouselSliderHtml;

    $this->registerJs("

    var ca2 = $('#{$sliderId}'); 
    if (ca2.length) {
        $('#{$sliderId}').carousel({
            interval: 4500 /* changes the speed */
        });
    }

", \yii\web\View::POS_END);

} else {
    echo '<!-- No active Partners -->';
}
