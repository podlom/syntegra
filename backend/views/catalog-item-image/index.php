<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\CatalogItemImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Catalog Item Images');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-item-image-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Catalog Item Image'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'id',
            'item_id',
            // 'product_title',
            'img_url:url',
            'sort',
            'published:boolean',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
