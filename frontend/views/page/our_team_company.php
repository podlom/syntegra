<?php
use frontend\helpers\PageHelper;

echo '<section class="comp-team">
<div class="comp-team__cap-wr">
<h3 class="comp-team__cap cap_type_orange">Team</h3>
<div class="comp-team__subtitle">If, for some reason, you can not open the tab you need, write to us here</div>
</div>
<div class="comp-team__slider-bl">
<div class="comp-team__slider">';

$team = PageHelper::getOurTeam();
if(!empty($team)){
    foreach ($team as $t){
        echo '<div class="comp-team__slider-item">
                <div class="comp-team__img-wr"><img src="'.$t->img.'" /></div>
                <div class="comp-team__info">
                    <div class="comp-team__name">'.$t->fullname.'</div>
                    <div class="comp-team__appointment">'.$t->position.'</div>
                </div>
             </div>';
    }
}




echo '
</div>
</div>
</section>';