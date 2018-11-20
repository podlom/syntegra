<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\SlideCategory;
use dosamigos\tinymce\TinyMce;
use common\helpers\LanguageHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Slide */
/* @var $form yii\widgets\ActiveForm */

$jsPrIt = <<<EOJS
    
    $(function(){
        $(document).on('click', '.showModal1Button', function(ev1){
            ev1.preventDefault();
            if ($('#modal1').data('bs.modal').isShown) {
                $('#modal1').find('#modalContent')
                    .load($(this).attr('value'));
                document.getElementById('modal1Header').innerHTML = '<button type="button" class="close" ' +
                    'data-dismiss="modal" aria-label="Close" aria-hidden="true">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button> ' /*+*/
                    /*'<h4 class="text-center">' + $(this).attr('title') + '</h4>';*/
            } else {
                $('#modal1').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
                document.getElementById('modal1Header').innerHTML = '<button type="button" class="close" ' +
                    'data-dismiss="modal" aria-label="Close" aria-hidden="true">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button> ' /*+*/
                    /*'<h4 class="text-center">' + $(this).attr('title') + '</h4>';*/
            }
        });
    });

EOJS;

$this->registerJs($jsPrIt);

?>

<div class="slide-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(SlideCategory::getSlideCategory(), ['prompt' => '...']) ?>

    <?= $form->field($model, 'lang')->dropDownList(LanguageHelper::getSiteLanguages1(), ['prompt' => '...']) ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'text')->widget(TinyMce::className()); ?>

    <?= $form->field($model, 'img_url')->textInput(['maxlength' => true]) ?>

    <div class="form-group img_url-preview">
    <?php

    if (!empty($model->img_url)) {
        echo '<img src="' . Url::to(\Yii::$app->urlManagerFrontend->baseUrl . $model->img_url, true) . '" alt="" title="">';
    }

    ?>
    </div>

    <?php

    yii\bootstrap\Modal::begin([
        'headerOptions' => ['id' => 'modal1Header'],
        // 'closeButton' => ['label' => 'Close'],
        'id' => 'modal1',
        'size' => 'modal-md',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
    ]);
    echo '<div id="modalContent"></div>';
    yii\bootstrap\Modal::end();

    ?>
    <?= Html::button(Yii::t('app', 'Upload image'), ['value' => Url::to(['/slide/upload-img']), 'title' => Yii::t('app', 'Upload image'), 'class' => 'showModal1Button btn']); ?>

    <div class="form-group img_url-preview">
        <?php

        if (!empty($model->img_url)) {
            echo '<img id="img_url-preview" src="' . Url::to(\Yii::$app->urlManagerFrontend->baseUrl . $model->img_url, true) . '" alt="" title="">';
        }

        ?>
    </div>

    <?= $form->field($model, 'img_url2')->textInput(['maxlength' => true]) ?>

    <div class="form-group img_url2-preview">
        <?php

        if (!empty($model->img_url2)) {
            echo '<img src="' . Url::to(\Yii::$app->urlManagerFrontend->baseUrl . $model->img_url2, true) . '" alt="" title="">';
        }

        ?>
    </div>

    <?= $form->field($model, 'href')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'published')->checkbox() ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput(['value' => date('Y-m-d H:i:s')]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['value' => date('Y-m-d H:i:s')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
