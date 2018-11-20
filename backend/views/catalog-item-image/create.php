<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CatalogItemImage */

$this->title = Yii::t('app', 'Create Catalog Item Image');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Catalog Item Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-item-image-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
