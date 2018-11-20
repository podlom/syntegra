<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CatalogCategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catalog-category-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'img_url') ?>

    <?= $form->field($model, 'published') ?>

    <?= $form->field($model, 'lang') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'sort') ?>

    <?php // echo $form->field($model, 'descr') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
