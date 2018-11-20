<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Метаданные';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meta-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить метаданные', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'label' => Yii::t('app', 'Url'),
                'format' => 'raw',
                'value' => 'url',
                'contentOptions' => ['style' => 'max-width: 350px;overflow:hidden;'],
            ],
            [
                'label' => Yii::t('app', 'Title'),
                'format' => 'raw',
                'value' => 'title',
                'contentOptions' => ['style' => 'max-width: 350px;overflow:hidden;'],
            ],
            // 'og_title',
            'published:boolean',
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        $options = [
                            'title' => 'Удалить',
                            'aria-label' => 'Удалить',
                            'data-confirm' => 'Вы уверены, что хотите удалить эти метаданные?',
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
