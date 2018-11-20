<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CatalogSubcategory3 */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Catalog Subcategory3',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Catalog Subcategory3s'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="catalog-subcategory3-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
