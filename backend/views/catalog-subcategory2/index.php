<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CatalogSubcategory2Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Catalog Subcategory2s');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-subcategory2-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Catalog Subcategory2'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'lang',
            'published',
            'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
