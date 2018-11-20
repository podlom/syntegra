<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CatalogSubcategory4Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catalog-subcategory4-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'lang') ?>

    <?= $form->field($model, 'published') ?>

    <?= $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
