<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TechnologiesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="technologies-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'img') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'slug') ?>

    <?= $form->field($model, 'lang') ?>

    <?php // echo $form->field($model, 'sort') ?>

    <?php // echo $form->field($model, 'published') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
