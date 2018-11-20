<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\helpers\CatalogItemHelper;


/* @var $this yii\web\View */
/* @var $model common\models\CatalogItemImage */
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

<div class="catalog-item-image-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'item_id')->dropDownList(CatalogItemHelper::getProducts(), ['prompt' => '...']) ?>

    <?= $form->field($model, 'img_url')->textInput(['maxlength' => true]) ?>

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
    <?= Html::button(Yii::t('app', 'Upload image'), ['value' => Url::to(['/catalog-item-image/upload-img']), 'title' => Yii::t('app', 'Upload image'), 'class' => 'showModal1Button btn']); ?>

    <div class="form-group img_url-preview">
        <?php

        if (!empty($model->img_url)) {
            echo '<img id="img_url-preview" src="' . Url::to(\Yii::$app->urlManagerFrontend->baseUrl . $model->img_url, true) . '" alt="" title="">';
        }

        ?>
    </div>

    <?php

    $sortVal = 1;
    if (intval($model->sort) > 0) {
        $sortVal = intval($model->sort);
    }

    ?>

    <?= $form->field($model, 'sort')->textInput(['value' => $sortVal]) ?>

    <?= $form->field($model, 'published')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
