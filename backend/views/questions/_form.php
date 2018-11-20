<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\helpers\QuestionsHelper;
use meysampg\formbuilder\FormBuilder;
use yii\helpers\Url;
use common\helpers\LanguageHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Questions */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="questions-form" >

    <?php

    if ($data != "") {
    echo '<div class="label-info">Loaded your lead form fields from the database.</div>';
    echo FormBuilder::widget([
    'data' => $data
    ]);
    }
    else {
    echo '<div class="label-info">Start to build your new lead form fields below.</div>';
    echo FormBuilder::widget();
    }

    $wrapHtml = <<<EOW

    <div class="setDataWrap">
        <button id="getXML" type="button">Get XML Data</button>
        <button id="getJSON" type="button">Get JSON Data</button>
        <button id="getJS" type="button">Get JS Data</button>
    </div>
    <div id="build-wrap"></div>

EOW;


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


$form = ActiveForm::begin();

    echo $wrapHtml;

    ?>

    <?= $form->field($model, 'image')->textInput() ?>

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
    <?= Html::button(Yii::t('app', 'Upload file'), ['value' => Url::to(['/questions/upload-img']), 'title' => Yii::t('app', 'Upload file'), 'class' => 'showModal1Button btn']); ?>

    <?= $form->field($model, 'title')->textInput()?>

    <?= $form->field($model, 'lang')->dropDownList(LanguageHelper::getSiteLanguages1(), ['prompt' => '...']) ?>

    <?= $form->field($model, 'id_group')->dropDownList(QuestionsHelper::getGroupQuestions()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


   <?php

  // var_dump($jsonData);
   $this->registerJs("


    setTimeout(function(){
    $('#w0-fb-element').hide();
    }, 123);

/**********************************/
   /* var fbEditor = document.getElementById('build-wrap');
    var formBuilder = $(fbEditor).formBuilder(
    {
        'dataType': 'json',
        'formData': '{$jsonData}',
        i18n: {
        locale: 'ru-RU'
        },
        disabledActionButtons: ['data','clear','save']
    });
   */
    var fbEditor = document.getElementById('build-wrap');

        var fields = [{
            label: 'Star Rating',
            attrs: {
                type: 'starRating'
            },
            icon: '🌟'
        }];
        var templates = {
            starRating: function(fieldData) {
                return {
                    field: '<span id=\"' + fieldData.name + '\">',
                    onRender: function() {
                        $(document.getElementById(fieldData.name)).rateYo({
                            rating: 3.6
                        });
                    }
                };
            }
        };
       var formBuilder = $(fbEditor).formBuilder({
            templates,
            fields,
            'dataType': 'json',
            'formData': '{$jsonData}',
            i18n: {
            locale: 'ru-RU'
            },
            disabledActionButtons: ['data','clear','save']
        });
  
    /*****************************************/



    $('.setDataWrap').hide();
    $('.label-info').hide();
    

    document.getElementById('getXML').addEventListener('click', function() {
    alert(formBuilder.actions.getData('xml'));
    });
    document.getElementById('getJSON').addEventListener('click', function() {
    alert(formBuilder.actions.getData('json', true));
    });
    document.getElementById('getJS').addEventListener('click', function() {
    alert('check console');
    console.log(formBuilder.actions.getData());
    });




    $('#w1 button[type=submit]').on('click', function(e){
       
      
         e.preventDefault();
            var data_form = formBuilder.actions.getData('json', true);
            var question_group_id = $('#questions-id_group').val();
            var title = $('#questions-title').val();
            var url1 = window.location;

            var image = $('#questions-image').val();
              var lang = $('#questions-lang').val();
             
                $.ajax({
                    method: \"post\",
                    url: url1,
                    data: {question_group_id:question_group_id, data_form:data_form, title:title, image:image, lang:lang},
                    success: function(html){
                 
                       window.location.replace('/questions/view?id='+html);
                    }
                });
        
        
       
       
    });
        
        
        ");

    ?>
</div>

