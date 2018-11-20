<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use backend\helpers\CatalogItemHelper;
use backend\helpers\CatalogColorHelper;
use common\models\CatalogSubcategory1;
use common\models\CatalogSubcategory2;
use common\models\CatalogSubcategory3;
use common\models\CatalogSubcategory4;
use dosamigos\tinymce\TinyMce;


/* @var $this yii\web\View */
/* @var $model common\models\CatalogItemVariant */
/* @var $form yii\widgets\ActiveForm */

$jsPrIt = <<<EOJS

    $('#catalogitemvariant-lang').change(function(e1){
        var la = $(this).val();
        // console.log('lang: ' + la);        
        $('#catalogitemvariant-sub_category1_id').empty().load('/catalog-item-variant/load-cat-opts', {'subcategory_id': 1, 'lang': la, '_csrf-backend': 'bC54bEpiVVMHaDodHlE3NAlcDFk7BT1.IkUbWRwVYxY0WTUFPyY.DA=='});
        $('#catalogitemvariant-sub_category2_id').empty().load('/catalog-item-variant/load-cat-opts', {'subcategory_id': 2, 'lang': la, '_csrf-backend': 'bC54bEpiVVMHaDodHlE3NAlcDFk7BT1.IkUbWRwVYxY0WTUFPyY.DA=='});
        $('#catalogitemvariant-sub_category3_id').empty().load('/catalog-item-variant/load-cat-opts', {'subcategory_id': 3, 'lang': la, '_csrf-backend': 'bC54bEpiVVMHaDodHlE3NAlcDFk7BT1.IkUbWRwVYxY0WTUFPyY.DA=='});
        $('#catalogitemvariant-sub_category4_id').empty().load('/catalog-item-variant/load-cat-opts', {'subcategory_id': 4, 'lang': la, '_csrf-backend': 'bC54bEpiVVMHaDodHlE3NAlcDFk7BT1.IkUbWRwVYxY0WTUFPyY.DA=='});
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

$subcategory1 = CatalogSubcategory1::find()->where(['lang' => $lang, 'published' => 1])->asArray()->all();
$data1 = ArrayHelper::map($subcategory1, 'id', 'title');

$subcategory2 = CatalogSubcategory2::find()->where(['lang' => $lang, 'published' => 1])->asArray()->all();
$data2 = ArrayHelper::map($subcategory2, 'id', 'title');

$subcategory3 = CatalogSubcategory3::find()->where(['lang' => $lang, 'published' => 1])->asArray()->all();
$data3 = ArrayHelper::map($subcategory3, 'id', 'title');

$subcategory4 = CatalogSubcategory4::find()->where(['lang' => $lang, 'published' => 1])->asArray()->all();
$data4 = ArrayHelper::map($subcategory4, 'id', 'title');

?>

<div class="catalog-item-variant-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->dropDownList(CatalogItemHelper::getProducts(), ['prompt' => '...']) ?>

    <?= $form->field($model, 'lang')->dropDownList(LanguageHelper::getSiteLanguages1(), ['prompt' => '...']) ?>

    <?= $form->field($model, 'sub_category1_id')->dropDownList($data1, ['prompt' => '...']) ?>

    <?= $form->field($model, 'sub_category2_id')->dropDownList($data2, ['prompt' => '...']) ?>

    <?= $form->field($model, 'sub_category3_id')->dropDownList($data3, ['prompt' => '...']) ?>

    <?= $form->field($model, 'sub_category4_id')->dropDownList($data4, ['prompt' => '...']) ?>

    <?= $form->field($model, 'default')->checkbox() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descr')->widget(TinyMce::className()); ?>

    <?= $form->field($model, 'description_short')->widget(TinyMce::className()); ?>

    <?= $form->field($model, 'articul')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'articul_1c')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'articul_epicentr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'length')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color_id')->dropDownList(CatalogColorHelper::getColors(), ['prompt' => '...']) ?>

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
    <?= Html::button(Yii::t('app', 'Upload image'), ['value' => Url::to(['/catalog-item-variant/upload-img']), 'title' => Yii::t('app', 'Upload image'), 'class' => 'showModal1Button btn']); ?>

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

    <?= $form->field($model, 'created_at')->textInput(['value' => date('Y-m-d H:i:s')]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['value' => date('Y-m-d H:i:s')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
