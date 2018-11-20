<?php

use yii\helpers\Url;
use yii\helpers\Html;


/** @var $slides common\models\Slide[] */

if (!empty($slides)) {

    $i = 0;
    $iClass = $iHtml = $sClass = $sHtml = '';

    foreach ($slides as $s1) {
        if ($i == 0) {
            $iClass = ' class="active"';
            $sClass = 'item active';
        } else {
            $iClass = '';
            $sClass = 'item';
        }
        // carousel indicators
        $iHtml .= '<li ' . $iClass . ' data-target="#carousel_slider-main" data-slide-to="' . $i . '"></li>';
        $sHtml .= '<div class="' . $sClass . '" style="background-image: url(' . $s1->img_url . ');">
                    <div class="show-video" data-src="' .  $s1->img_url2 . '">Показать видео</div>
                    <!--img(src="images/bg/bg_images_section_0.jpg")-->
                    <div class="sl-cont-wr">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-0 col-sm-1 col-md-1 col-lg-1"></div>
                                <div class="col-xs-0 col-sm-0 col-md-3 col-lg-3"></div>
                                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                    <div class="item-inner">
                                        <h1>' . $s1->text . '</h1>
                                    </div>
                                </div>
                           </div>
                        </div>                       
                    </div>
           
                </div>';
        $i ++;
    }

    $slider2top = $this->render('//slide/homePageSlider2top', [
        'lang'    => $lang,
        'slides'  => $slides2,
    ]);

    $slider2bottom = $this->render('//slide/homePageSlider2bottom', [
        'lang'    => $lang,
        'slides'  => $slides2,
    ]);

    $carouselSliderHtml = <<<EOS

        <!-- Section 1 -->
          <section class="tpl__section section-1">
            <div class="section-inner">
              <div class="carousel carousel-main slide" id="carousel_slider-main">
              
              <!-- Indicators -->
              <div class="main-slider-indicators-wr">
                  <div class="container-fluid">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-4">
                            <ol class="carousel-indicators">
                              {$iHtml}
                            </ol>
                        </div>
                    </div>
                  </div>
              </div>
                    
                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                  {$sHtml}                  
                </div>
              </div>
              
              <div class="section-1-banner">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-xs-0 col-sm-1 col-md-1 col-lg-1"></div>
                    <div class="col-xs-0 col-sm-0 col-md-3 col-lg-3"></div>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8" id="floor_decor">
                        <a class="scroll-block" href="#floor_decor">
                        <div class="block block-images">
                          <div class="block-inner">
                              <div class="com__images">
                                <figure><img src="/images/img/scroll_down.png" alt=""></figure>
                              </div>
                          </div>
                        </div></a>
                      {$slider2top}                      
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
          </section>
        <!-- end Section 1 -->
        <div class="video-overlay"></div>
        <div class="video-wr-inslider">
            <span class="close-video"></span>
            <div class="video-inwr">
            </div>
        </div>
        {$slider2bottom}

EOS;

echo $carouselSliderHtml;

$this->registerJs("
     
    $('.section-1-banner').on('click', 'a.scroll-block', function (event) {
        event.preventDefault();
        var id  = $(this).attr('href'),
            top = $(id).offset().top;
        $('body,html').animate({scrollTop: top}, 1500);
    });

", \yii\web\View::POS_END);

} else {
    echo '<!-- No slides to display -->';
}
