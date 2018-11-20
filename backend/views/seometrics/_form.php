<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\Segment;
use common\components\DetectPlatform;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model backend\models\ArticleForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">
    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'host')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'value')->widget(TinyMce::className()); ?>

    <?= $form->field($model, 'published')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
