<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 16.05.2017
 * Time: 14:16
 */

use common\widgets\Alert;


?>

<!-- Section 6 -->
<section class="tpl__section section-6">
    <div class="section-inner">
        <div class="container-fluid">

            <div id="request-result-msg">
                <?= Alert::widget() ?>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                    <div class="block block-text">
                        <div class="block-inner">
                            <p><strong>Хотите сотрудничать?</strong></p>
                            <p>Заполните форму заявки и мы с вами свяжемся.</p>
                        </div>
                    </div>
                </div>

                <form id="cowForm1" action="/site/coworking-request" method="post">

                    <div class="col-xs-0 col-sm-0 col-md-1 col-lg-1"></div>
                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                        <div class="block block-form">
                            <div class="block-inner">
                                <input type="text" placeholder="<?=Yii::t('app', 'First Name')?>" id="coworkingrequest-first_name" name="CoworkingRequest[first_name]" aria-required="true" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                        <div class="block block-form">
                            <div class="block-inner">
                                <input type="text" placeholder="<?=Yii::t('app', 'Last Name')?>" id="coworkingrequest-last_name" name="CoworkingRequest[last_name]" aria-required="true" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                        <div class="block block-form">
                            <div class="block-inner">
                                <input type="email" placeholder="eMail" id="coworkingrequest-email" name="CoworkingRequest[email]" aria-required="true" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-2 col-lg-2">
                        <div class="block block-button">
                            <div class="block-inner"><a id="sendCowReq1" class="btn btn-primary btn-primary-border small" href="#"><?=Yii::t('app', 'Submit')?></a></div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>
<!-- end Section 6 -->

<?php

/*
    TODO: Yii2 active form JS validation
*/
$this->registerJsFile('/js/assets/yii.js', ['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJsFile('/js/assets/yii.validation.js', ['depends' => [yii\web\JqueryAsset::className()]]);
$this->registerJsFile('/js/assets/yii.activeForm.js', ['depends' => [yii\web\JqueryAsset::className()]]);

/*
 * @see http://stackoverflow.com/questions/30153705/yii-2-0-csrf-validation-for-ajax-request
 * $('meta[name=csrf-param]').prop('content'): $('meta[name=csrf-token]').prop('content')
 * */
$this->registerJs("

    $('#cowForm1').submit(function(){
        console.log('Coworking request form sumbit handler');
        
        var form = $(this);
        var fAct = '/site/coworking-request';
        if (form.find('.has-error').length) {
          return false;
        }
    
        $.ajax({
          url: fAct,
          type: 'post',
          data: form.serialize(),
          success: function(msgs) {
            console.log('Form submit cussess: ' + msgs);
          }
        });
    
        return false;    
    });

    $('#sendCowReq1').click(function(e1){
       
        console.log('Coworking request form sumbit handler');
        $('#cowForm1').submit();
        
        e1.preventDefault();        
        return false;
    });

", \yii\web\View::POS_END);

?>
