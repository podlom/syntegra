<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\LanguageHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Team */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="team-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripton')->textarea(['rows' => 6]) ?>

   <?= $form->field($model, 'lang')->dropDownList(LanguageHelper::getSiteLanguages1(), ['prompt' => '...']) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'published')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
