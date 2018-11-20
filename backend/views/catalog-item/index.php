<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CatalogItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Catalog Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <p>
        <?= Html::a(Yii::t('app', 'Create Catalog Item'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Add Catalog Item Gallery'), ['/catalog-item-image/index'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'id',
            'category_id',
            'slug',
            'sku',
            'lang',
            // 'title',
            // 'descr:ntext',
            // 'price',
            'width',
            'height',
            'sort',
            'published:boolean',
            // 'created_at',
            // 'updated_at',
            // 'img_url:url',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
