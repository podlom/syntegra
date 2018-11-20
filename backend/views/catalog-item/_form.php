<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\CatalogSubcategory1;
use common\models\CatalogSubcategory2;
use common\models\CatalogSubcategory3;
use common\models\CatalogSubcategory4;
use backend\helpers\CatalogCategoryHelper;


/* @var $this yii\web\View */
/* @var $model common\models\CatalogItem */
/* @var $form yii\widgets\ActiveForm */

/*
$subcategory1 = CatalogSubcategory1::find()->asArray()->all();
$data1 = ArrayHelper::map($subcategory1, 'id', 'title');

$subcategory2 = CatalogSubcategory2::find()->asArray()->all();
$data2 = ArrayHelper::map($subcategory2, 'id', 'title');

$subcategory3 = CatalogSubcategory3::find()->asArray()->all();
$data3 = ArrayHelper::map($subcategory3, 'id', 'title');

$subcategory4 = CatalogSubcategory4::find()->asArray()->all();
$data4 = ArrayHelper::map($subcategory4, 'id', 'title');
*/

$jsPrIt = <<<EOJS

    $('#catalogitem-lang').change(function(e1){
        var la = $(this).val();
        // console.log('lang: ' + la);        
        $('#catalogitem-category_id').empty().load('/catalog-item/load-cat-opts', {'lang': la, '_csrf-backend': 'bC54bEpiVVMHaDodHlE3NAlcDFk7BT1.IkUbWRwVYxY0WTUFPyY.DA=='});
    });
    
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

$lang = 'ru';
if (isset($model->lang)) {
    $lang = $model->lang;
}

?>

<div class="catalog-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lang')->dropDownList(LanguageHelper::getSiteLanguages1(), ['prompt' => '...']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(CatalogCategoryHelper::getCategories($lang), ['prompt' => '...']) ?>

    <?= $form->field($model, 'sku')->textInput(['maxlength' => true]) ?>

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
    <?= Html::button(Yii::t('app', 'Upload image'), ['value' => Url::to(['/catalog-item/upload-img']), 'title' => Yii::t('app', 'Upload image'), 'class' => 'showModal1Button btn']); ?>

    <div class="form-group img_url-preview">
        <?php

        if (!empty($model->img_url)) {
            echo '<img id="img_url-preview" src="' . Url::to(\Yii::$app->urlManagerFrontend->baseUrl . $model->img_url, true) . '" alt="" title="">';
        }

        ?>
    </div>

    <?= $form->field($model, 'width')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'height')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surface')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'montage_way')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quantity')->checkbox() ?>

    <?= $form->field($model, 'created_at')->textInput(['value' => date('Y-m-d H:i:s')]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['value' => date('Y-m-d H:i:s')]) ?>

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
