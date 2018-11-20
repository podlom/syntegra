<?php
/* @var $this yii\web\View */

$formatter = \Yii::$app->formatter;
$html = $html1='';

if(!empty($news)){
    $i = 0;
    foreach ($news['lastNews'] as $n){
        if($i == 0){
            $html .= '  <div class="our-blog__big-item"><a class="our-blog__img-wr" href="/page/'.$n->slug.'">
                              <div class="our-blog__img" style="background-image: url('.$n->img_url.');"></div>
                              <div class="our-blog__big-item-date">'.$formatter->asDate($n->pubdate, 'dd / MM / yy').'</div></a>
                            <div class="our-blog__big-item-cont">
                              <h4 class="our-blog__item-title"><a href="/blog/'.$n->slug.'">'.$n->title.'</a></h4>
                              <div class="our-blog__big-item-txt">
                                '.$n->announce.'
                              </div>
                              <div class="our-blog__more"><a href="#">'.Yii::t('app','Read more').'</a></div>
                            </div>
                          </div>';
        }
        else{
            $html1 .= ' <div class="our-blog__list-item">
                  <div class="our-blog__list-item-date">'.$formatter->asDate($n->pubdate, 'dd / MM / yy').'</div>
                  <h4 class="our-blog__item-title"><a href="/blog/'.$n->slug.'">'.$n->title.'</a></h4>
                  <div class="our-blog__list-item-txt">
                     '.$n->announce.'
                  </div>
                  <div class="our-blog__more"><a href="/blog/'.$n->slug.'">'.Yii::t('app','Read more').'</a></div>
                </div>';
        }
        $i++;

    }
}
echo $page->announce;
echo $this->render('our_team_company');
echo '<section class="our-blog">
        <div class="wrap wrap_size_large wow fadeInUp">
          <h3 class="our-blog__cap cap_type_orange">Our blog</h3>
          <div class="our-blog__wr">
            <div class="our-blog__big-item-bl">
             '.$html.'
            </div>
            <div class="our-blog__list-bl">
              <div class="our-blog__list">
              
              '.$html1.'
              
              </div>
            </div>
          </div>
        </div>
      </section>';

echo '<section class="cases-n-advent">
<div class="wrap wrap_size_large">
<div class="cases-n-advent__wr">
<div class="case-studies wow fadeInLeft">
<h3 class="cap_type_orange">'.$page->title2.'</h3>
<div class="cases-n-advent__subtilte">'.$page->body2.'</div>
<div class="case-studies__wr">';

echo $this->render('/page/case_studies_company.php');

echo '</div>
</div>
<div class="advant wow fadeInRight">
<h3 class="cap_type_orange">'.$page->title1.'</h3>
<div class="cases-n-advent__subtilte">'.$page->body1.'</div>
<div class="advant__wr">';

if(!empty($subpages)){
    foreach ($subpages as $subp){
        echo'<div class="advant__item">
                <h4>'.$subp->title.'</h4>
                <p>'.$subp->announce.'</p>
            </div>';

    }
}



echo'
</div>
</div>
</div>
</div>
</section>';


echo $this->render('reviews', compact('page'));

echo $this->render('vacancies', compact('page'));
