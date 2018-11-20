<?php
echo '<section class="section_content_top bg_color_grey">
<div class="wrapp wr-content_top">
<h2 class="cap_type_orange">'.$page->title2.'</h2>
<div class="subtitle_cap">'.$page->body2.'</div>
<!--img(src="images/bg/pover_bi.png")--></div>
</section>
<section class="main-content">
<div class="wrap wrap_size_large">
<div class="main-content__wr">
<div class="main-content__title-wr">
<h2 class="cap_type_orange">'.$page->title3.'</h2>
</div>
<div class="main-content__text-wr">
<div class="main-content__text user_text">
'.$page->body3.'
</div>
</div>
</div>
</div>
</section>
';
echo   '<section class="section_service-go-visual  bg_color_grey">
<div class="wr-section_cont">
<h2 class="cap_type_orange">'.$page->title1.'</h2>
<div class="subtitle_cap">'.$page->body1.'</div>
</div>
<div class="block_item-services">

';
if(!empty($subpages)){
    foreach ($subpages as $p) {
        echo '
            <div class="item-services__go-visual">
                <a class="item-services__link" href="/page/'.$p->slug.'">
                      <div class="item-services__wrapp">
                            <div class="item-services__go-visual-cap">'.$p->title.'</div>
                            <div class="item-services__go-visual_info">'.$p->announce.'</div>
                      </div>
                </a>
            </div>

';
    }
}


echo
'</div>
</section>
';