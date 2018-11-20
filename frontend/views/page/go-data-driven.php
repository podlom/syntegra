<?php


//echo $page->body;

echo '<section class="main-content bg_color_grey">
<div class="wrap wrap_size_large">
<div class="main-content__wr">
<div class="main-content__title-wr">
<h2 class="cap_type_orange">'.$page->title1.'</h2>
</div>
<div class="main-content__text-wr">
<div class="main-content__text user_text">
'.$page->body1.'
</div>
</div>
</div>
</div>
</section>
<section class="section-industries-slider">
<div class="wr-row">
<div class="section-industries-slider-col flex-col">
<h3 class="section-industries-slider-title cap_type_orange">'.$page->title2.'</h3>
<div class="section-industries-slider-txt">'.$page->body2.'</div>
<div class="navigate-slider-btn">
<div id="next-right" class="arrow-btn">&nbsp;</div>
<div id="prev-left" class="arrow-btn">&nbsp;</div>
</div>
</div>
<div class="industries-slider-wr">
<div class="industries-slider">';
if(!empty($subpages)){
    foreach ($subpages as $subp){

        echo '<div class="industries-slider__item">
                <div class="industries-slider__icon industries-slider__icon_id_'.$subp->sort.'">&nbsp;</div>
                <div class="industries-slider__title"><a href="/page/'.$subp->slug.'">'.$subp->title.'</a></div>
            </div>';

    }
}



echo '
</div>
</div>
</div>
</section>
<section class="technoused">
<div class="wrap wrap_size_middle">
<div class="technoused__title-wr">
<h3 class="technoused__cap cap_type_orange">'.$page->title3.'</h3>
<div class="technoused__subtitle">'.$page->body3.'</div>
</div>
<div class="technoused-wr">';

echo $this->render('technologies');

echo '
</div>
</div>
</section>';