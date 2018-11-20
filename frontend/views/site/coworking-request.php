<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CoworkingRequest */
/* @var $form ActiveForm */
?>
<div class="site-coworking-request">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'first_name') ?>
        <?= $form->field($model, 'last_name') ?>
        <?= $form->field($model, 'email') ?>
    
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-coworking-request -->
