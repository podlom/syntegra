<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\LanguageHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Reviews */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reviews-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'work_place')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripton')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'lang')->dropDownList(LanguageHelper::getSiteLanguages1(), ['prompt' => '...']) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'published')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
