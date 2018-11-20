<?php

/* @var $this yii\web\View */
/* @var $meta common\models\Meta */
/* @var $page common\models\Page */
$title = Yii::t('app', 'Home');
$this->title = $page->title;

if($category['slug'] == 'consulting' ) {
    echo $this->render('consulting_item',compact('page','title','category','meta'));
}
else{
    if ($page) {

        echo '<section class="underhead" style="background-image:url('.$page->img_url.');">
        <div class="wrap wrap_size_large">
          <div class="breadcrumbs">
            <ul>
              <li><a href="/">' . $title . '</a></li>
              <li><span>' . $page->title . '</span></li>
            </ul>
          </div>
          <h3 class="underhead__title wow fadeInLeft">' . $page->title . '</h3>
        </div>
      </section>';

        $formatter = \Yii::$app->formatter;
        $html = $html1='';
        if($slug == 'company'){
            echo $this->render('company',compact('news','page','category','subpages'));
        }
       
        else if($slug == 'go-data-driven'){
            echo $this->render('go-data-driven',compact('page','subpages'));
        }
        else if($slug == 'go-servless'){
           echo $this->render('go-servless',compact('subpages','page'));
        }

        else if( $slug == 'go-visual'){
            echo $this->render('go-visual',compact('subpages','page'));
        }
        else{
            echo $page->body;
        }
    }

}

if($data !== NULL){
    echo $this->render('//site/question_form',[ 'data' =>  $data,
        'jsonData'  =>  $jsonData,"id_question"=>$page->question_id,'url_prefix'=>$url_prefix]);
}

echo $this->render('/site/footer');