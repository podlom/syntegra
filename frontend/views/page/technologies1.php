<?php

//use frontend\helpers\PageHelper;
use backend\models\PartnerTechnology;

$technologies = PartnerTechnology::getTechnologiesByPartnerId($partner_id);
//var_dump($technologies);die;
//$technologies = PageHelper::getTechnologies();
if(!empty($technologies)){
    foreach ($technologies as $t){
        echo '<div class="technoused-el">
                <p>'.$t['title'].'</p>
                <img draggable="true" src="'.$t['img'].'" />
             </div>';
    }
}