<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CatalogSubcategory2 */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Catalog Subcategory2',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Catalog Subcategory2s'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="catalog-subcategory2-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
