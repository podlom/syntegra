<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BlockSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="block-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'slug') ?>

    <?= $form->field($model, 'lang') ?>

    <?= $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'body') ?>

    <?php // echo $form->field($model, 'sort') ?>

    <?php // echo $form->field($model, 'published') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
