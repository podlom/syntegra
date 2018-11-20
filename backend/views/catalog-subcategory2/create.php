<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CatalogSubcategory2 */

$this->title = Yii::t('app', 'Create Catalog Subcategory2');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Catalog Subcategory2s'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-subcategory2-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
