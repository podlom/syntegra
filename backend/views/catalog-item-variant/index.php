<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CatalogItemVariantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Catalog Item Variants');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-item-variant-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Catalog Item Variant'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'id',
            'product_id',
            'default:boolean',
            'articul',
            'price',
            'length',
            'color_id',
            // 'img_url:url',
            'sort',
            'published:boolean',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
