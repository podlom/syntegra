<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\helpers\CatalogCategoryHelper;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model common\models\Block */
/* @var $form yii\widgets\ActiveForm */

$jsPrIt = <<<EOJS

    $('#block-lang').change(function(e1){
        var la = $(this).val();
        // console.log('lang: ' + la);        
        $('#block-category_id').empty().load('/catalog-item/load-cat-opts', {'lang': la, '_csrf-backend': 'bC54bEpiVVMHaDodHlE3NAlcDFk7BT1.IkUbWRwVYxY0WTUFPyY.DA=='});
    });

EOJS;

$this->registerJs($jsPrIt);

$lang = 'ru';
if (isset($model->lang)) {
    $lang = $model->lang;
}

?>

<div class="block-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(CatalogCategoryHelper::getCategories($lang), ['prompt' => '...']) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lang')->dropDownList(LanguageHelper::getSiteLanguages1(), ['prompt' => '...']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'body')->widget(TinyMce::className()); ?>



    <?php

    $sortVal = 1;
    if (intval($model->sort) > 0) {
        $sortVal = intval($model->sort);
    }

    ?>

    <?= $form->field($model, 'sort')->textInput(['value' => $sortVal]) ?>

    <?= $form->field($model, 'published')->checkbox() ?>

    <?= $form->field($model, 'created_at')->textInput(['value' => date('Y-m-d H:i:s')]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['value' => date('Y-m-d H:i:s')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
