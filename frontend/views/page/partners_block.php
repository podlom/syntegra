<?php
use frontend\helpers\PageHelper;

$partners = PageHelper::getPartners();
if(!empty($partners)){
    foreach ($partners as $t){
        echo '<div class="partners__logo"><img src="'.$t->img.'" draggable="true"></div>';

    }
}
