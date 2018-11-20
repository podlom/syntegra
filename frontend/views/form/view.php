<?php

use meysampg\formbuilder\FormBuilder;


/* @var $this yii\web\View */


if (!empty($data)) {
    echo '<div class="label-info">Loaded your lead form fields from the database.</div>';
    echo FormBuilder::widget([
        'data' => $data,
    ]);

} else {
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

echo $wrapHtml;

$this->registerJs("

setTimeout(function(){
$('#w0-fb-element').hide();
}, 123);
    
/********************************/
var fbEditor = document.getElementById('build-wrap');
var formBuilder = $(fbEditor).formBuilder({'dataType': 'json', 'formData': '/*{$jsonData}*/'});
/*
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
           
        });
*/
/********************************/

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

    ");