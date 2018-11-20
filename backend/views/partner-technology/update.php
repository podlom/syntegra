<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PartnerTechnology */

$this->title = 'Update Partner Technology: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Partner Technologies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="partner-technology-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
