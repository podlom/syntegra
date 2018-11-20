<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Seo метрики';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить метрику', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
                'slug',
                'host',
                'published:boolean',
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        $options = [
                            'title' => 'Удалить',
                            'aria-label' => 'Удалить',
                            'data-confirm' => 'Вы уверены, что хотите удалить метрику?',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    },
                ],
            ],
        ],
    ]); ?>

</div>
