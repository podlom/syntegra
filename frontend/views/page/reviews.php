<?php
use frontend\helpers\PageHelper;

echo '<section class="reviews">
<div class="reviews__title-wr wow fadeInUp">
<h3 class="cap_type_orange">'.$page->title3.'</h3>
<div class="reviews__subtitle">'.$page->body3.'</div>
</div>
<div class="reviews__slider">';


$reviews = PageHelper::getReviews();
if(!empty($reviews)){
    foreach ($reviews as $r){
        echo '
    <div class="reviews__slider-item">
        <div class="reviews__slider-item-wr">
        <div class="reviews__name">'.$r->fullname.'</div>
        <div class="reviews__appointmen">'.$r->work_place.'</div>
            <div class="reviews__txt">'.$r->descripton.'</div>
        </div>
    </div>';
    }
}


echo'
</div>
</section>';