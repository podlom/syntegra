<?php

/* @var $this yii\web\View */
/* @var $meta common\models\Meta */
/* @var $partners common\models\Partner[] */


$home =  Yii::t('app', 'Home');
//$title =  Yii::t('app', 'Partners Category');
$title =  Yii::t('app', 'Case Studies');
$this->title = $title;

if (!empty($partners_category)) {

    $partnersHtml = '';
    //$partner_category = $partners_category[0]->id;
    $partner_category = 'financial';
    $active = '';
    foreach ($partners_category as $part1) {
        if($part1->slug == $partner_category){
            $active = " class='active'";
        }
        else{
            $active = " ";
        }
        $partnersHtml .= '<li> <a href="#" data-partner-category-slug="'.$part1->slug.'" '.$active.'>' . $part1->title . '</a></li>';

    }

} else {
    echo '<!-- No active Partners -->';
}
?>





<section class="underhead">
    <div class="wrap wrap_size_large">
        <div class="breadcrumbs">
            <ul>
                <li><a href="/"><?=$home?></a></li>
                <li><span><?=$title?></span></li>
            </ul>
        </div>
        <h3 class="underhead__title wow fadeInLeft"><?=$title?></h3>
    </div>
</section>
<section class="partners-content">
    <div class="wrap wrap_size_large">
        <div class="partners-cats">
            <ul class="partners-cats__wr">
                <?=$partnersHtml?>
            </ul>
        </div>
        <div class="partners-list"  id="partnersContainer">


        </div>
        <div class="partners-btn-wr" id="loadMorePartners" data-partner-category-id=<?=$partner_category?> ><a class="btn" href="#">Show more</a></div>
    </div>
</section>




<?php
echo $this->render('/site/footer');
?>


<script>
    window.onload = (function() {
        $('#loadMorePartners').hide();
        var page = 0;
        var limit = <?=$cnt?>;
        var offset = 0;
        function newPage() {
            page ++;
        }

        function newOffset() {
            if (page > 0) {
                offset +=  limit ;
            } else {
                offset = 0;
            }
        }
    $('.partners-cats__wr li').on('click', function(e){

        e.preventDefault();
        page = 0;
        offset = 0;

        $.each($('.partners-cats__wr a'), function(){
            $(this).removeClass('active');
        });
        $(this).find('a').addClass('active');
        $('#partnersContainer').empty();

        var partner_category = $(this).find('a').data('partner-category-slug');
        $('#loadMorePartners').data('partner-category-slug', partner_category);

        loadPartners(partner_category);
    });

        $('#loadMorePartners').on('click', function (e) {

            e.preventDefault();
            var partner_category = $(this).data('partner-category-slug');

            loadMorePartners(partner_category);

        });

        function loadMorePartners(partner_category) {
            newPage();
            newOffset();
            loadPartners(partner_category);
        }

        var url_pref = "<?=$url_prefix;?>";
        function loadPartners(partner_category){
            var expr = '<a class=';
            $.ajax({
                type: 'POST',
                url: url_pref+'/partner-category/partners',
                data: {
                    'limit': limit,
                    'offset': offset,
                    'partner_category': partner_category,
                    '<?= Yii::$app->request->csrfParam ?>': '<?= Yii::$app->request->getCsrfToken()?>'
                },
                success: function (html) {
                    console.log(html);
                    console.log(html.indexOf(expr));
                    if(html.indexOf(expr) !== -1){
                        if (html) {
                            $('#partnersContainer').append(html);
                            $('#loadMorePartners').show();
                        }
                    }
                    else {
                        $('#loadMorePartners').hide();
                    }

                }
            });
        }

       loadPartners('<?=$partner_category?>');

});


</script>