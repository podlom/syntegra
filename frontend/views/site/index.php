<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $meta common\models\Meta */

// $this->title = 'Syntegra | Home';
//var_dump($page);
$this->title = isset($meta->title) ? $meta->title : $this->title;
$h1 = isset($meta->h1) ? $meta->h1 : Yii::t('app', 'Syntegra');
$detail = Yii::t('app', 'Detail');
?>
    <div class="banner__bg">
        <div class="banner__content">
            <div class="banner__wr_content"><?=$page->announce?>
                <button class="banner__btn_yellow"><?=$detail?></button>
            </div>
        </div>
    </div>
    <section class="section section_slider">
        <div class="slider__wr">
            <?php echo $this->render('/site/slider');?>
        </div>
    </section>


<?php
echo $page->body;

echo $this->render('//page/our_team_home',compact('page'));

echo '
    <section class="section section_partners">
    <div class="section_content__wrapp  wow fadeInUp">
    <div class="partners_wrapp__logo">';

echo $this->render('//page/partners_block');

echo '</div>
    <h2 class="section_partners__title">'.$page->title3.'</h2>
    </div>
    </section>';

echo $this->render('footer');


