<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\helpers\LanguageHelper;

/* @var $this yii\web\View */
/* @var $model common\models\PartnerCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="partner-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>



    <div class="form-group logo_url-preview">
        <?php

        if (!empty($model->logo_url)) {
            echo '<img src="' . Url::to(\Yii::$app->urlManagerFrontend->baseUrl . $model->logo_url, true) . '" alt="" title="">';
        }

        ?>
    </div>

    <?= $form->field($model, 'lang')->dropDownList(LanguageHelper::getSiteLanguages1(), ['prompt' => '...']) ?>

    <?= $form->field($model, 'published')->checkbox() ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput(['value' => date('Y-m-d H:i:s')]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['value' => date('Y-m-d H:i:s')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
