<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Vacancies */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vacancies-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripton')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'published')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
