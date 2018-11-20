<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CatalogItem */

$this->title = Yii::t('app', 'Create Catalog Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Catalog Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
