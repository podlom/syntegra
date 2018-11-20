<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 21.07.2017
 */

$sHtml = '';

if (!empty($slides)) {
    $sHtml .= '<section class="tpl__section section-about-slider gwrap">
    <div class="section-inner">
        <div class="container-fluid">
            <div class="slider-about">';

    $slIdx = -1;
    foreach ($slides as $slide) {
        $imgUrl = '/images/slider/imgslide1.jpg';
        if (!empty($slide->img_url)) {
            $imgUrl = $slide->img_url;
        }
        $sHtml .= '<div class="slider-about_item">
                        <div class="clearfix">
                            <div class="slider-about_imgwr">
                                <img src="' . $imgUrl . '" alt="">
                            </div>
                            <div class="slider-about_item_txt">
                                ' . $slide->text . '
                            </div>
                        </div>
                    </div>';
        $slIdx ++;
    }

    $sHtml .= '
            </div>
        </div>
    </div>
</section>';

}

echo $sHtml;
