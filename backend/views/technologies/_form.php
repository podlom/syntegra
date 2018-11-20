<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Technologies */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="technologies-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'published')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
