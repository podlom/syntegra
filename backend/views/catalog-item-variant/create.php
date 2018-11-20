<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CatalogItemVariant */

$this->title = Yii::t('app', 'Create Catalog Item Variant');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Catalog Item Variants'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-item-variant-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
