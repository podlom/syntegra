<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;


$this->title = Yii::t('app', 'Feedback');
/*
$this->params['breadcrumbs'][] = $this->title;
*/
?>
<div class="form-block">
    <h2><?= Html::encode($this->title) ?></h2>

        <div id="contact-message">
            <?= Yii::$app->session->getFlash('success') ?>
            <?= Yii::$app->session->getFlash('error') ?>
        </div>

        <?php $form = ActiveForm::begin(['id' => 'contact-form', 'enableAjaxValidation' => false,]); ?>

            <?= $form->field($model, 'name', ['inputOptions' => ['class' => 'name-inp']])->textInput()->input('name', ['placeholder' => Yii::t('app','Name')])->label(false) ?>

            <?= $form->field($model, 'email', ['inputOptions' => ['class' => 'email-inp']])->textInput()->input('email', ['placeholder' => "eMail"])->label(false) ?>

            <?= $form->field($model, 'body', ['inputOptions' => ['class' => 'email-inp']])->textarea(['rows' => 4, 'placeholder' => Yii::t('app', 'Message')])->label(false) ?>

            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                'template' => '<div class="row capt-control"><div class="col-xs-3 capimgwr">{image}</div><div class="col-lg-9 col-sm-9 spiwr">{input}</div></div>',
            ]) ?>

            <div class="form-controls form-controls-button">
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => '', 'name' => 'contact-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>


</div>
