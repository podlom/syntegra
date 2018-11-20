<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 07.06.2017
 * Time: 16:41
 */


/* @var $videoConsultant common\models\VideoConsultant[] */

?>

<!-- Section 13 -->

<?php

if (!empty($videoConsultant)) {

    $iCatId = 4;
    $sVidHtml = '';
    foreach ($videoConsultant as $vi) {
        // $figure = '<figure><img src="/images/image_section_13_1.jpg" alt=""></figure>';
        $iCatId = $vi->category_id;
        $sVidHtml .= '<div class="video-slide">
                            <div class="block block-video-consultant">
                                <div class="block-inner">
                                    <div class="block-video-consultant_title d-table">
                                        <div class="d-cell">
                                            <h4>' . $vi->title . '</h4>
                                        </div>
                                    </div>
                                    <div class="block-video-consultant_image">
                                        <div class="com__images com__image-resizable">
                                            ' . $vi->video_url . '
                                        </div>
                                    </div>
                                    <div class="block-video-consultant_desc small-desc">
                                        <h5>' . $vi->short_descr . '</h5>
                                    </div>
                                </div>
                            </div>
                        </div>';
    }
    $sVidHtml .= '';

?>
<section class="tpl__section section-13">
    <div class="section-inner">
        <div class="block block-collapse_top">
            <div class="block-inner">
                <div class="block-video-cap" data-target="#demo-<?=$iCatId?>"><?=Yii::t('app', 'Video')?></div>
            </div>
        </div>
        <div class="block block-collapse_bottom">
            <div class="block-inner">
                <div id="demo-<?=$iCatId?>">
                    <div class="videoslider">
                        <?=$sVidHtml?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php

} else {
    echo '<!-- No video consultant for this products category added yet. -->';
}

$this->registerJsFile('@web/js/slick.min.js', ['depends' => ['yii\web\JqueryAsset']]);

?>

<!-- end Section 13 -->