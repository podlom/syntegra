<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'News');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create News'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'sort',
            'lang',
            [
                'label' => Yii::t('app', 'Slug'),
                'format' => 'raw',
                'value' => 'slug',
                'contentOptions' => ['style' => 'max-width: 320px;overflow:hidden;'],
            ],
            [
                'label' => Yii::t('app', 'Title'),
                'format' => 'raw',
                'value' => 'title',
                'contentOptions' => ['style' => 'max-width: 360px;overflow:hidden;'],
            ],
            [
                'attribute' => 'pubdate',
                'format' => ['date', 'php:d/m/Y']
            ],
            // 'announce:ntext',
            // 'body:ntext',
            // 'source',
            'published:boolean',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
