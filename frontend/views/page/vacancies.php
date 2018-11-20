<?php
use frontend\helpers\PageHelper;

echo '<section class="joinus">
<div class="joinus__bg">&nbsp;</div>
<div class="wrap wrap_size_middle">
<div class="joinus__wr wow fadeInUp">
'.$page->body.'
<div class="joinus__vacancies">';


$vacancies = PageHelper::getVacancies();
if(!empty($vacancies)){
    foreach ($vacancies as $v){
        echo '
                <div class="title-acc">
                    <div class="joinus__vacancy-title-wr">
                        <div class="joinus__vacancy-title">'.$v->position.'</div>
                        <div class="joinus__location">'.$v->city.'</div>
                    </div>
                </div>
                 <div class="content-acc">
                      <div class="joinus__text">'.$v->descripton.'</div>
                </div>';

    }
}




echo '
</div>
</div>
</div>
</section>';
