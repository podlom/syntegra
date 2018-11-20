<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use meysampg\formbuilder\FormBuilder;
use frontend\helpers\FormHelper;
FormBuilder::widget([
    'data' => $data,
]);

$this->title = 'Contact';
//   #download_file_form

?>

    <div class="modal-window_forms">
        <div class="modal-over"></div>
        <div class="modal-window_wrapp">
            <div class="modal-window-caption cap_type_orange">Make request</div>
            <div class="modal-window-body" id="modal2">
                <div class="modal_close"></div>
                <div class="modal_div__inner-wr" id="modal2_inner">
                    <form id="fb-render" action="/answer/create" class="form-question"></form>
                    <input type="checkbox" id="privacy_check"><a href="/page/privacy" target="_blank">I agree with privacy policy</a>
                </div>
            </div>
        </div>
    </div>

<!--div-- class="modal_div" id="modal2">
    <div class="modal_close"></div>
    <div class="modal_div__inner-wr">
        <form id="fb-render" action="/answer/create" class="form-question"></form>
        <input type="checkbox" id="privacy_check"><a href="/page/privacy" target="_blank">I agree with privacy policy</a>

    </div>
</div-->

<?php

$js1='';
if(FormHelper::getDownloadFileUrl($id_question) != null && !empty(FormHelper::getDownloadFileUrl($id_question))){
    $js1 = " $('#send-question-form').hide();";

    if(FormHelper::isInBlackListIP() === false) {
        $js1 .= "$('#modal2_inner').append('<a href=\"" . FormHelper::getDownloadFileUrl($id_question) . "\" class=\"banner__btn_yellow\" style=\"display: block;\">Download file</a>');";
    }
    else{
        $js1 .= "$('#modal2_inner').append('<br>You don\'t have permission for downloading the file');";
    }
}
else{
    $js1 = "
    $('#modal2').hide();
    ";
}


$this->registerJs("
    var fbRender = document.getElementById('fb-render');

    var formData = '".$jsonData."';
 
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
  var formRenderOpts = {
   templates,
            fields,
    formData,
    dataType: 'json'
  };

  $(fbRender).formRender(formRenderOpts);
  
  $('#privacy_check').on('click', function(){
        var checked = $(this).is(\":checked\");
        if(checked){
            $('#modal2_inner').append('<a id=\"send-question-form\" class=\"banner__btn_yellow\" style=\"display: block;\" >Sumbit form</a>');
        }
        else{
            $('#send-question-form').remove();
        }
  });
  
   $('#modal2').on('click','#send-question-form', function(e){
       e.preventDefault();
       var form = $('#fb-render');
    
             var rateYo = $('.jq-ry-container').rateYo();
             var rating = rateYo.rateYo('rating'); 
            
             var data_form = form.serialize()+'&rating='+rating;
             
            //console.log(data_form); console.log(rating);  return;
            // var data_form = formBuilder.actions.getData('json');
              var url_pref = '".$url_prefix."';
            var url = url_pref+'/answers/send';
        
                $.ajax({
                    method: \"post\",
                    url: url,
                    data: {question_id:".$id_question.", data_form:data_form},
                    success: function(html){
                      //window.location.replace('/site/index');
                    ".$js1."
                    }
                });
                
  });
");