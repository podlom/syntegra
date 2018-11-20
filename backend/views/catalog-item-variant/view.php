<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model common\models\CatalogItemVariant */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Catalog Item Variants'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-item-variant-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'product_id',
            'default:boolean',
            'sub_category1_id',
            'sub_category2_id',
            'sub_category3_id',
            'sub_category4_id',
            'articul',
            'articul_1c',
            'articul_epicentr',
            'price',
            'lang',
            'title',
            'descr:ntext',
            'description_short',
            'length',
            'color_id',
            'img_url:url',
            'sort',
            'published:boolean',
            'created_at',
            'updated_at',
            'image'
        ],
    ]) ?>

</div>
