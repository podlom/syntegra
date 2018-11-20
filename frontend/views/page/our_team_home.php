<?php
use frontend\helpers\PageHelper;

echo '<section class="section section-our-team">
<div class="section-our-team__content__wrap">
<div class="wr__our-team  wow fadeInUp">';

$team = PageHelper::getOurTeam();
if(!empty($team)){
    $i=0;
    foreach ($team as $t){
        if($i<3)
        echo '<div class="our-team__item"><img src="'.$t->img.'" />
                 <div class="our-team__name first">
                    <div class="item__name">'.$t->fullname.'</div>
                    <div class="item__position">'.$t->position.'</div>
                </div>
              </div>
                ';
        $i++;
    }
}

echo '
</div>
</div>
<div class="section-our-team__speech  wow fadeInUp">
<div class="section-our-team__content">
'.$page->body3.'
<img src="/images/signature.png" /></div>
</div>
</section>';