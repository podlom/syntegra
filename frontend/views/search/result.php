<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $foundNews frontend\models\News[] */
/* @var $foundPages frontend\models\Page[] */

if (isset($searchResults)) {
    echo '<h1>' . Yii::t('app', 'You have searched for:') . ' ' . Html::encode($searchResults['queryParams']['search']) . '</h1><hr>';

    if (!empty($foundNews)) {
        echo '<h2>' . Yii::t('app', 'Found in news') . '</h2>';
        foreach ($foundNews as $ni) {
            echo '<div class="news-item-container"><a href="/' . $lang . '/news/' . $ni->slug .
                '"><span class="newsDate">' . $ni->pubdate . '</span> ' .
                $ni->title .
                '</a><div class="news-announce">' .
                $ni->announce . '</div></div>';
        }
        echo '<hr>';
    }

    if (!empty($foundPages)) {
        echo '<h2>' . Yii::t('app', 'Found in pages') . '</h2>';
        foreach ($foundPages as $pi) {
            echo '<div><a href="/' . $lang . '/page/' . $pi->slug . '">' .
                $pi->title . '</a><div class="page-announce">' .
                $pi->announce . '</div></div>';
        }
        echo '<hr>';
    }
}
