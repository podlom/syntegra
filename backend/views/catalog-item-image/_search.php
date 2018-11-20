<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CatalogItemImageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catalog-item-image-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'item_id') ?>

    <?= $form->field($model, 'img_url') ?>

    <?= $form->field($model, 'sort') ?>

    <?= $form->field($model, 'published') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
