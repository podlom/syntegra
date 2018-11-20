<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 01.06.2017
 * Time: 15:25
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\models\UploadCatalogCategoryImageForm */
/* @var $form yii\widgets\ActiveForm */

$js = <<< EOJS


$('body').on('beforeSubmit', 'form#upload-category-img-form1', function() {
    var form = $(this),
        formData = new FormData($(this)[0]);
        
    if (form.find('.has-error').length) {
      return false;
    }

    $.ajax({
      url: form.attr('action'),
      type: 'post',
      data: formData,
      async: false,
      cache: false,
      contentType: false,
      enctype: 'multipart/form-data',
      processData: false,
      success: function(data) {
        if (data.length > 0) {
            $('#image-preview').hide();
            $('#questions-image').attr('value', data);
        }
        $('#modal1').modal('hide');
      }
    });

    return false;
});

EOJS;

$this->registerJs($js);


?><div class="upload-news-img-form"><?php

$form = ActiveForm::begin(['action' => ['/questions/upload-img'], 'id' => 'upload-category-img-form1', 'options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'imageFile')->fileInput() ?>

    <button><?= Yii::t('app', 'Upload file') ?></button>

<?php ActiveForm::end() ?>

</div>