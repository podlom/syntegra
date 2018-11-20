<?php

/* @var $this yii\web\View */
/* @var $partners common\models\Partner[] */

if (!empty($partners)) {
    $partnersHtml = '<!-- Partners Section -->
<div class="row">
    <div style="" class="col-lg-12">
        <h2 class="page-header text-center partnHdr">
            ' . Yii::t('app', 'Partners') . '
        </h2>
    </div>
</div>
<div class="row">
    <div id="partLogosCont" class="center-block">
';
    foreach ($partners as $part1) {
        $partnersHtml .= '<img src="' . $part1->logo_url . '" class="img-responsive" alt="' . $part1->title . '">';
    }

    $partnersHtml .= '</div>
</div>';

    echo $partnersHtml;

} else {
    echo '<!-- No active Partners -->';
}
