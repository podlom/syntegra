<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact';

?>
<div class="modal_div" id="modal1">
    <div class="modal_close"></div>
    <div class="modal_div__inner-wr">
        <h3><?= Html::encode($this->title) ?></h3>

        <?php $form = ActiveForm::begin(['id' => 'contact-form', 'action' =>['/site/contact-form-acept']]); ?>


                <?= $form->field($model, 'name')->textInput(['autofocus' => false]) ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'message')->textarea() ?>


            <div class="form-group btn-wr">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
