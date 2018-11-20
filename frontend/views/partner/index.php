<?php

/* @var $this yii\web\View */
/* @var $meta common\models\Meta */
/* @var $partners common\models\Partner[] */

$title = Yii::t('app', 'Home');
$title1 = Yii::t('app', 'Partners');
?>
    <section class="underhead-partner">
        <div class="wrap wrap_size_large">
            <div class="breadcrumbs">
                <ul>
                    <li><a href="/"><?=$title?></a></li>
                    <li><a href="/case-studies"><?=$title1?></a></li>



<?php
$title2 = '';
if (!empty($partner)) {
    $title2 = $partner->title;
    ?>
    <li><span><?=$title2?></span></li>
    </ul>
    </div>
    <div class="underhead-partner__cont">
        <div class="underhead-partner__cont-wr">
            <div class="underhead-partner__imgwr wow fadeInDown"><img src="<?=$partner->logo_url?>"></div>
            <div class="underhead-partner__txt wow fadeInUp">
                <h3> <?=Yii::t('app','Description of the problem')?>:</h3>
                <p><?=$partner->description?></p>
            </div>
        </div>
    </div>
    </div>
    </section>
    <section class="funcreq">
        <div class="wrap wrap_size_large">
            <div class="funcreq__wr">
                <div class="funcreq__cap-bl">
                    <h3 class="funcreq__cap cap_type_orange wow fadeInLeft"><?=$partner->title1?></h3>
                </div>
                <div class="funcreq__cont wow fadeInRight">
                    <?=$partner->block1?>
                </div>
            </div>
        </div>
    </section>
    <section class="decision">
        <div class="wrap wrap_size_middle">
            <div class="decision__wr">
                <div class="decision__titles wow fadeInLeft">
                    <h3 class="decision__cap cap_type_orange"><?=$partner->title2?></h3>
                    <h6 class="decision__subtitle">Portal for working with financial documents</h6>
                </div>
                <div class="decision__cont wow fadeInUp">
                    <?=$partner->block2?>
                </div>
            </div>
        </div>
    </section>
    <section class="technoused">
        <div class="wrap wrap_size_middle">
            <h3 class="technoused__cap cap_type_orange wow fadeInLeft"><?=$partner->title3?></h3>
            <div class="technoused-wr wow fadeInUp">
                <?php echo $this->render('/page/technologies1', ['partner_id'=>$partner->id]);?>
            </div>
        </div>
    </section>

    <?php
} else {
    echo '<!-- No active Partners -->';
}

$this->title = $title1.' - '.$title2;

if(!empty($sibling_partners)){
    echo '<section class="other-partners">';
    foreach ($sibling_partners as $s){
        echo '  <div class="other-partners__el"><a href="/partner/'.$s['slug'].'">
            <div class="other-partners__img-wr"><img src="'.$s['logo_url'].'"></div></a></div>';
    }
    echo '</section>';
}

echo $this->render('/site/footer');