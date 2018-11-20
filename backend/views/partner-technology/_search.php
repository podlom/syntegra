<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PartnerTechnologySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="partner-technology-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'partner_id') ?>

    <?= $form->field($model, 'technology_id') ?>

    <?= $form->field($model, 'lang') ?>

    <?= $form->field($model, 'sort') ?>

    <?php // echo $form->field($model, 'published') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
