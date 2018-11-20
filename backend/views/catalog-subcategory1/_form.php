<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CatalogSubcategory1 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catalog-subcategory1-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lang')->dropDownList(LanguageHelper::getSiteLanguages1(), ['prompt' => '...']) ?>

    <?= $form->field($model, 'published')->checkbox() ?>

    <?= $form->field($model, 'created_at')->textInput(['value' => date('Y-m-d H:i:s')]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['value' => date('Y-m-d H:i:s')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
