<?php

/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 14.11.2017
 * Time: 17:27
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\models\UploadCatalogCategoryImageForm */
/* @var $form yii\widgets\ActiveForm */

$js = <<< EOJS

$('body').on('beforeSubmit', 'form#upload-slide-img-form1', function() {
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
            $('#img_url-preview').hide();
            $('#slide-img_url').attr('value', data);
        }
        $('#modal1').modal('hide');
      }
    });

    return false;
});

EOJS;

$this->registerJs($js);


?><div class="upload-news-img-form"><?php

$form = ActiveForm::begin(['action' => ['/slide/upload-img'], 'id' => 'upload-slide-img-form1', 'options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'imageFile')->fileInput() ?>

    <button><?= Yii::t('app', 'Upload Gallery Image') ?></button>

<?php ActiveForm::end() ?>

</div>