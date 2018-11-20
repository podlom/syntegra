<?php

/* @var $this yii\web\View */
/* @var $meta common\models\Meta */
/* @var $news frontend\models\News[] */
$title = Yii::t('app', 'Home');
$title1 =  Yii::t('app', 'Blog');
$this->title = $title1;
$formatter = \Yii::$app->formatter;
$htmlNews1=$htmlNews2 = '';
if (!empty($news)) {
    $i = 0;
    foreach ($news as $n){
        if($i % 4 == 0){
            $htmlNews1 =' <div class="spec-blog-item-outer wow fadeInUp">
            <div class="wrap wrap_size_large">
              <div class="spec-blog-item">
                <div class="spec-blog-item__date">'.$formatter->asDate($n->pubdate, 'dd / MM / yy').'</div>
                <div class="spec-blog-item__title-wr">
                  <h2 class="spec-blog-item__title">'.$n->title.'</h2>
                </div>
                <div class="spec-blog-item__txt-n-button">
                  <div class="spec-blog-item__txt">'.$n->announce.'</div>
                  <div class="spec-blog-item__button"><a class="btn" href="/blog/'.$n->slug.'">'.Yii::t('app','Full Article').'</a></div>
                </div>
              </div>
            </div>
          </div>';
        }
        else{
            $htmlNews2 .= '<div class="normal-blog-items__el">
                    <div class="normal-blog-items__el-inner"><a class="normal-blog-items__el-img-wr" href="#">
                        <div class="normal-blog-items__el-date">'.$formatter->asDate($n->pubdate, 'dd / MM / yy').'</div>
                        <div class="normal-blog-items__el-img" style="background-image: url('.$n->img_url.');"></div></a>
                      <div class="normal-blog-items__cont"><a class="normal-blog-items__el-title" href="#">
                          <h2>'.$n->title.'</h2></a>
                        <div class="normal-blog-items__el-txt">
                            '.$n->announce.'
                        </div>
                        <div class="normal-blog-items__el-btn-wr"><a class="btn" href="/blog/'.$n->slug.'">'.Yii::t('app','Full Article').'</a></div>
                      </div>
                    </div>
                  </div>';
        }
        $i++;

    }

} else {
    ?>
    <script>
        $('#more_news').hide();
    </script>
<?php
}?>

    <section class="blog-section">
        <?=$htmlNews1?>
        <div class="normal-blog-items-outer">
            <div class="wrap wrap_size_large">
                <div class="normal-blog-items">
                    <div class="normal-blog-items__inner wow fadeInUp">
                        <?=$htmlNews2?>
                    </div>
                </div>
            </div>
        </div>
    </section>

