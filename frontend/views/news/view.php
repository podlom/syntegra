<?php

use yii\helpers\Html;
$formatter = \Yii::$app->formatter;
/* @var $this yii\web\View */
/* @var $meta common\models\Meta */

$title = Yii::t('app', 'Home');
$title1 =  Yii::t('app', 'Blog');
$this->title = $title1;


if ($news) {


?>

<section class="underhead" style="background-image: url(<?=$news->img_url?>);">
        <div class="wrap wrap_size_large">
          <div class="breadcrumbs">
            <ul>
              <li><a href="/"><?=$title?></a></li>
              <li><a href="/blog"><?=$title1?></a></li>
              <li><span><?=$news->title?></span></li>
            </ul>
          </div>
          <h3 class="underhead__title wow fadeInLeft"><?=$news->title?></h3>
        </div>
        <div class="underhead__date-wr">
          <div class="wrap wrap_size_large">
            <div class="underhead__date"><?=$formatter->asDate($news->pubdate, 'dd / MM / yy')?></div>
          </div>
        </div>
      </section>
      <section class="main-content">
        <div class="wrap wrap_size_large">
          <div class="main-content__wr">
            <div class="main-content__title-wr">
              <h2 class="cap_type_orange wow fadeInLeft">Research</h2>
            </div>
            <div class="main-content__text-wr">
              <div class="main-content__text user_text wow fadeInUp">
                  <?=$news->body?>
              </div>
            </div>
          </div>
        </div>
          <?php
         $fbWidget = $this->render('//site/_social_fb_share', ['product_id' => $news->id, 'slug'=>$news->slug]);
          $twWidget = $this->render('//site/_social_tw_share', ['product_id' => $news->id, 'slug'=>$news->slug]);
          $gpWidget = $this->render('//site/_social_gp_share', ['product_id' => $news->id, 'slug'=>$news->slug]);
          ?>
          <div class="social-section">
              <div class="enter-user">
                  Поделиться с друзьями:
              </div>
              <div class="wr-icon">
                  <div class="share-gp item-social">
                      <img src="/images/google.svg" alt="">
                      <?= $gpWidget ?>
                  </div>
                  <div class="share-fb item-social">
                      <img src="/images/facebook.svg" alt="">
                      <?= $fbWidget ?>
                  </div>
                  <div class="share-tw item-social">
                      <img src="/images/twitter.svg" alt="">
                      <?= $twWidget ?>
                  </div>
              </div>
          </div>
      </section>
<?php

} else {
    echo '<h1 class="error-404">There is nothing to display here.</h1>';
}
echo $this->render('/site/footer');