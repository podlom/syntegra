<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\PartnerTechnology;

/* @var $this yii\web\View */
/* @var $model backend\models\PartnerTechnology */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="partner-technology-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'partner_id')->dropDownList(PartnerTechnology::getPartners(), ['prompt' => '...']) ?>

    <?= $form->field($model, 'technology_id')->dropDownList(PartnerTechnology::getTechnologies(), ['prompt' => '...']) ?>

    <?= $form->field($model, 'lang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'published')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
