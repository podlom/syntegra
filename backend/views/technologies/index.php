<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TechnologiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Technologies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="technologies-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Technologies', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'img',
            'title',
            'slug',
            'lang',
            //'sort',
            //'published',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
