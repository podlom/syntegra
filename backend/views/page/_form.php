<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\helpers\PageCategoryHelper;
use dosamigos\tinymce\TinyMce;
use backend\helpers\QuestionsHelper;
use common\helpers\LanguageHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Page */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(PageCategoryHelper::getCategories(), ['prompt' => '...']) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'announce')->widget(TinyMce::className()); ?>

    <?= $form->field($model, 'body')->widget(TinyMce::className()); ?>

    <?= $form->field($model, 'lang')->dropDownList(LanguageHelper::getSiteLanguages1(), ['prompt' => '...']) ?>

    <?= $form->field($model, 'published')->checkbox() ?>

    <?= $form->field($model, 'question_id')->dropDownList(QuestionsHelper::getQuestions(), ['prompt' => '...']) ?>

    <?= $form->field($model, 'title1')->textInput() ?>

    <?= $form->field($model, 'body1')->widget(TinyMce::className()); ?>

    <?= $form->field($model, 'title2')->textInput() ?>

    <?= $form->field($model, 'body2')->widget(TinyMce::className()); ?>

    <?= $form->field($model, 'title3')->textInput() ?>

    <?= $form->field($model, 'body3')->widget(TinyMce::className()); ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput(['value' => date('Y-m-d H:i:s')]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['value' => date('Y-m-d H:i:s')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
