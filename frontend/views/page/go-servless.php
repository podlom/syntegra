<?php
echo '<section class="section_content_top bg_color_grey">
<div class="wrapp wr-content_top">
<h2 class="cap_type_orange">'.$page->title2.'</h2>
<div class="container-fluid">
<div class="row">
<div class="col-lg-6">
<div class="content_section-azure">
    '.$page->body2.'
</div>
<img src="/images/ms-azure.png" /></div>
<div class="col-lg-6"><img src="/images/azure.png" /></div>
</div>
</div>
</div>
</section>';
echo   '<section class="section_service-go-visual">
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
echo '<section class="section_microsoft-office bg_color_grey">
<div class="microsoft-office__wr">
<div class="wr-col">
<h2 class="microsoft-office__cap cap_type_orange">'.$page->title3.'</h2>
<div class="microsoft-office__content">
'.$page->body3.'
</div>
</div>
<div class="microsoft-office-wr__img"><img src="/images/bg/office.png" /></div>
</div>
</section>';