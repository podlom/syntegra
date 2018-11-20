<?php

/* @var $this yii\web\View */
$title = Yii::t('app', 'Home');


if ($pages) {

    echo'<section class="underhead">
        <div class="wrap wrap_size_large">
          <div class="breadcrumbs">
            <ul>
              <li><a href="/">'.$title.'</a></li>
              <li><span>'.$category['title'].'</span></li>
            </ul>
          </div>
          <h3 class="underhead__title wow fadeInLeft">'.$category['title'].'</h3>
        </div>
      </section>';
    $title = $category['title'];
    $this->title = $title;

    if($category['slug'] == 'services'  ) {
    echo    ' <section class="section section_slider">
        <div class="slider__wr">
          ';
    echo $this->render('/site/slider');
    echo'

        </div>
      </section>';
    }

if($category['slug'] == 'consulting') {
    echo '
    <section class="consulting-list">
        <div class="wrap wrap_size_large">
          <div class="consulting-list__wr wow fadeInUp">';

    foreach ($pages as $p) {
        echo ' <div class="consulting-list__item"><a href="/page/' . $p->slug . '">
                <div class="consulting-list__icon consulting-list__icon_index_0"></div>
                <h4 class="consulting-list__title">' . $p->title . '</h4>
                <div class="consulting-list__text">' . $p->announce . '</div></a></div>';
    }
    echo '          </div>
        </div>
      </section>
    ';
}
    echo $this->render('/site/footer');
    ?>
    <?php
} else {
    echo '<h1 class="error-404">There is nothing to display here.</h1>';
}