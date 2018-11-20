<?php

/* @var $lagestNews frontend\models\News[] */

use yii\helpers\Html;
use yii\helpers\Url;


if (!empty($latestNews)) {
    echo '<div class="row">
        <div class="col-lg-12">
            <h2 class="page-header text-center newsHdr">
                ' . Yii::t('app', 'Finance news') . '
            </h2>
        </div>
    </div>';

    foreach($latestNews as $ni) {
        // echo '<pre>' . var_export($ni->title, 1) . '</pre><br>';
        echo '<div class="row_news">' .
                '<div class="block_img">' .
                    '<img class="img_news" src="' . $ni->img_url . '" alt="' . Html::encode($ni->title) . '" title="' . Html::encode($ni->title) . '">' .
                '</div>' .
                '<div class="block_text">' .
                    '<h3 class"news_title">' . $ni->title . '</h3>' .
                    '<div class="newsAnnounce">' . $ni->announce . '</div>' .
                '</div>' .
            '</div>';
    }
/*
    $moreNewsUrl = Url::to(Yii::getAlias('@web') . $lang . '/news');

    echo '<div class="row">
        <div class="col-lg-12 text-right">
            <a href="' . $moreNewsUrl . '">' . Yii::t('app', 'Find out more') . ' &gt;&gt;</a>
        </div>
    </div>';
 * 
 */
} else {
    echo '<!-- No news added to display -->';
}
