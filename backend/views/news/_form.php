<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use dosamigos\tinymce\TinyMce;
use common\helpers\LanguageHelper;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pubdate')->textInput(['value' => date('Y-m-d')]) ?>

    <?= $form->field($model, 'announce')->widget(TinyMce::className()); ?>


    <?= $form->field($model, 'body')->widget(TinyMce::className()); ?>

    <!--<?= $form->field($model, 'body')->widget(TinyMce::className(), [
        'options' => ['rows' => 6],
        'language' => 'ru',
        'clientOptions' => [
            'plugins' => [
                'advlist autolink lists link charmap hr preview pagebreak',
                'searchreplace wordcount textcolor visualblocks visualchars code fullscreen nonbreaking',
                'save insertdatetime media table contextmenu template paste image responsivefilemanager filemanager',
            ],
            'toolbar' => 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | responsivefilemanager link image media',
            'external_filemanager_path' => '/plugins/responsivefilemanager/filemanager/',
            'filemanager_title' => 'Responsive Filemanager',
            'external_plugins' => [
                //Иконка/кнопка загрузки файла в диалоге вставки изображения.
                'filemanager' => '/plugins/responsivefilemanager/filemanager/plugin.min.js',
                //Иконка/кнопка загрузки файла в панеле иснструментов.
                'responsivefilemanager' => '/plugins/responsivefilemanager/tinymce/plugins/responsivefilemanager/plugin.min.js',
            ],
            //'relative_urls' => false,
            //'document_base_url'=>  Yii::getAlias('@frontendBaseUrl'),
        ]
    ]);?>-->

    <!--<?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>-->

    <?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img_url')->textInput(['maxlength' => true]) ?>

    <div class="form-group img_url-preview">
    <?php

    if (!empty($model->img_url)) {
        echo '<img src="' . Url::to(\Yii::$app->urlManagerFrontend->baseUrl . $model->img_url, true) . '" alt="" title="">';
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
