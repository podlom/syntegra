<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\VideoConsultantSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="video-consultant-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'lang') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'img_url') ?>

    <?php // echo $form->field($model, 'video_url') ?>

    <?php // echo $form->field($model, 'short_descr') ?>

    <?php // echo $form->field($model, 'published') ?>

    <?php // echo $form->field($model, 'sort') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
