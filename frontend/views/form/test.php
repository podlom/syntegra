<?php
use meysampg\formbuilder\FormBuilder;
FormBuilder::widget([
    'data' => $data,
]);
?>
    <section class="underhead-question bg_color_grey">
        <div class="wrap wrap_size_large">
            <div class="breadcrumbs">
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><span><?=$title?></span></li>
                </ul>
            </div>
            <div class="underhead-question_wr">
                <h3 class="underhead-question__title cap_type_orange"><?=$title?></h3>
            </div>
        </div>
    </section>


    <section class="section-form">

        <form id="fb-render" action="answer/create" class="form-question"></form>
        <div><a class="banner__btn_yellow" id="send-question-form">next</a></div>

    </section>


<?php

echo $this->render('/site/footer');
?>

  <?php
$this->registerJs("
    var fbRender = document.getElementById('fb-render');

    var formData = '".$jsonData."';
    
    $(function(){

        //hiding labels of elements
       // $('form label').attr('class').hide();
       
       $.each($('form label'), function(){
          
          
            if($(this).attr('class')){
                //$(this).hide();
            }
       });
    });
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
  
  $('#send-question-form').on('click', function(e){
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
                      //console.log('tt'+html);
                       window.location.replace('/site/index');
                    }
                });
                
  });
");