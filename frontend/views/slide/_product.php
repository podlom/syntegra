<!-- Section 7 -->
<section class="tpl__section section-7" style="background-image: url(<?=$blocks[0]->img_url?>)">
    <div class="section-inner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-0 col-sm-6 col-md-9 col-lg-9"></div>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 padding-none">
                    <div class="block block-bathroom_decor">
                        <div class="block-inner">
                            <h3><a href="<?= $blocks[0]->href;?>"><?= $blocks[0]->title;?></a></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- end Section 7 -->
<!-- Section 8 -->

<section class="tpl__section section-8">
    <div class="section-inner">
        <div class="container-fluid" style="background-image: url(<?=$blocks[1]->img_url?>)">
            <div class="row section-8__first-row">
                <div class="col-xs-0 col-sm-0 col-md-0 col-lg-2"></div>
                <div class="col-xs-12 col-sm-6 col-md-9 col-lg-7 padding-left">
                    <div class="block block-text sptxtincatinfo">
                        <div class="block-inner">
                            <?=$blocks[0]->text;?>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 padding-none">
                    <div class="block block-images">
                        <div class="block-inner">
                            <div class="com__images com__image-resizable section8__second-img-wr">
                                <figure><img src="<?=$blocks[0]->img_url2?>" alt=""></figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 section-8__bl-cap-wr">
                    <div class="block block-title">
                        <div class="block-inner">
                            <h3><a href="<?= $blocks[1]->href;?>"><?= $blocks[1]->title;?></a></h3>
                        </div>
                    </div>
                </div>
                <div class="col-xs-0 col-sm-6 col-md-9 col-lg-9 spwrwimg" style="background-image: url(<?=$blocks[1]->img_url?>)"></div>
            </div>
        </div>
        <div class="container-fluid section-8__secbl-w-txt">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 padding-none">
                    <div class="block block-images">
                        <div class="block-inner">
                            <div class="com__images com__image-resizable section8__second-img-wr-in-second-bl">
                                <figure><img src="<?=$blocks[1]->img_url2?>" alt=""></figure>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-9 col-lg-7 padding-right">
                    <div class="block block-text sptxtincatinfo">
                        <div class="block-inner">
                            <?=$blocks[1]->text;?>
                        </div>
                    </div>
                </div>
                <div class="col-xs-0 col-sm-0 col-md-0 col-lg-3"></div>
            </div>
        </div>
    </div>
</section>
<!-- end Section 8 -->
<!-- Section 9 -->
<section class="tpl__section section-9" style="background-image: url(<?=$blocks[2]->img_url?>)">
    <div class="section-inner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-0 col-sm-6 col-md-8 col-lg-8 spdiwimgonl-wr">
                    <div class="spdiwimgonl" style="background-image: url(<?=$blocks[2]->img_url?>)">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 padding-none">
                    <div class="block block-title">
                        <div class="block-inner">
                            <h3><a href="<?= $blocks[2]->href;?>"><?=$blocks[2]->title;?></a></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-0 col-sm-6 col-md-8 col-lg-8 padding-none">
                    <div class="block block-text sptxtincatinfo">
                        <div class="block-inner">
                            <p><?=$blocks[2]->text;?></p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 padding-none">
                    <div class="block block-image">
                        <div class="block-inner">
                            <div class="com__images com__image-resizable section9__imgwr">
                                <figure><img src="<?=$blocks[2]->img_url2?>" alt=""></figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end Section 9 -->