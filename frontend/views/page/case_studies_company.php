<?php

use common\models\Partner;

$partners = Partner::find()->select('id, slug, logo_url')->where(['category_id'=>2])->all();
//var_dump($partners);
if(!empty($partners)){
    foreach ($partners as $p){
        echo '<div class="case-studies__item"><a href="/partner/'.$p->slug.'"><img src="'.$p->logo_url.'" /></a></div>';
    }
}

            echo         '<div class="case-studies__item"><a href="/case-studies">View all casse</a></div>';