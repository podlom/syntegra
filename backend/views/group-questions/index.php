<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\GroupQuestionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Group Questions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-group-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Group Questions'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'description',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
