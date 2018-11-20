<?php
    use frontend\helpers\SliderHelper;

?>

<div class="slider__slick">

    <?php

    $pages = SliderHelper::actionSlikServices();

    if(!empty($pages)) {
        foreach ($pages as $p) {
            echo '<a href="page/' . $p->slug . '">
                <div class="slick__item_wr">
                  <div class="item_slick" style="background-image:url(' . $p->img_url . ');"></div>
                  <div class="slick__content">' . $p->title . '</div>
                </div></a>';
        }
    }
    ?>

</div>