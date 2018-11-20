<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use common\helpers\LanguageHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\MetaForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="meta-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'og_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(TinyMce::className()); ?>

    <?= $form->field($model, 'og_description')->widget(TinyMce::className()); ?>

    <?= $form->field($model, 'keywords')->widget(TinyMce::className()); ?>

    <!--<?= $form->field($model, 'keywords')->textarea(['rows' => 3]) ?>-->


    <?= $form->field($model, 'h1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo')->widget(TinyMce::className()); ?>

    <!--<?= $form->field($model, 'seo')->textarea(['rows' => 3]) ?>-->

    <?= $form->field($model, 'og_image')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'meta_image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lang')->dropDownList(LanguageHelper::getSiteLanguages1(), ['prompt' => '...']) ?>
    <?= $form->field($model, 'published')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
