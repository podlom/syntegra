<?php

use frontend\helpers\PageHelper;

$technologies = PageHelper::getTechnologies();
if(!empty($technologies)){
    foreach ($technologies as $t){
        echo '<div class="technoused-el">
                <p>'.$t->title.'</p>
                <img draggable="true" src="'.$t->img.'" />
             </div>';
    }
}