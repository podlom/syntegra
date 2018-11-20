<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Page'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            'id',
            'category_id',
            'sort',
            'lang',
            'slug',
            [
                'label' => Yii::t('app', 'Title'),
                'format' => 'raw',
                'value' => 'title',
                'contentOptions' => ['style' => 'max-width: 360px;overflow:hidden;'],
            ],
            /* [
                'format' => 'raw',
                'value' => 'announce',
                'contentOptions' => ['style' => 'max-width: 360px;overflow:hidden;'],
            ], */
            // 'body:ntext',
            'published:boolean',
            // 'created_at',
            // 'updated_at',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
