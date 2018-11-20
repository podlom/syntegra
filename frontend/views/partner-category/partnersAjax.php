<?php
$html = '';
if(!empty($partnersData)){
    foreach ($partnersData as $p){
        $html .= "<a class=\"partner-item\" href=\"/partner/{$p->slug}\">
                    <div class=\"partner-item__img-wr\"><img src=\"{$p->logo_url}\"></div>
                    <div class=\"partner-item__info\">
                        <div class=\"partner-item__info-wr\">
                            <div class=\"partner-item__title\">{$p->title}</div>
                            <div class=\"partner-item__text\">{$p->short_description}</div>
                        </div>
                    </div>
                </a>
";
    }

    echo $html;
}
?>
