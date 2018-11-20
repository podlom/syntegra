<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PartnerTechnology */

$this->title = 'Create Partner Technology';
$this->params['breadcrumbs'][] = ['label' => 'Partner Technologies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-technology-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
