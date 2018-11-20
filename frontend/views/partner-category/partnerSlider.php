<?php


?>
<!-- Partners Section -->
<div class="row">
    <div style="" class="col-lg-12">
        <h2 class="page-header partnHdr">
            <span class="padPartnHdr"><?= Yii::t('app', 'Partners') ?></span>
        </h2>
    </div>
</div>
<div class="row">
    <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:980px;height:100px;overflow:hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" style="position:absolute;top:0px;left:0px;background-color:rgba(0,0,0,0.7);">
            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
            <div style="position:absolute;display:block;background:url('img/part-logo/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
        </div>
        <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:980px;height:100px;overflow:hidden;">
            <div>
                <img data-u="image" src="/img/part-logo/BRAZ.jpg" />
            </div>
            <div>
                <img data-u="image" src="/img/part-logo/bc.jpg" />
            </div>
            <div>
                <img data-u="image" src="/img/part-logo/bl.jpg" />
            </div>
            <div>
                <img data-u="image" src="/img/part-logo/logo_BRAZ_1color.jpg" />
            </div>
            <div>
                <img data-u="image" src="/img/part-logo/logo_BRAZ_CONSTRUCTION_1color.jpg" />
            </div>
            <div>
                <img data-u="image" src="/img/part-logo/logo_BRAZ_LINE_1color.jpg" />
            </div>
            <div>
                <img data-u="image" src="/img/part-logo/logo_BRAZ.jpg" />
            </div>
            <div>
                <img data-u="image" src="/img/part-logo/logo_BRAZ_CONSTRUCTION.jpg" />
            </div>
            <div>
                <img data-u="image" src="/img/part-logo/logo_BRAZ_LINE.jpg" />
            </div>
            <div>
                <img data-u="image" src="/img/part-logo/logo_BRAZ_1color.jpg" />
            </div>
            <div>
                <img data-u="image" src="/img/part-logo/logo_BRAZ_CONSTRUCTION_1color.jpg" />
            </div>
            <div>
                <img data-u="image" src="/img/part-logo/logo_BRAZ_LINE_1color.jpg" />
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

<?php

$this->registerJs("

    jssor_1_slider_init();

", \yii\web\View::POS_END);
