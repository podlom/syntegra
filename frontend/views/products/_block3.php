<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 07.08.2017
 */

/* @var $block common\models\Block */

if (!empty($block)) {

    $blockHtml = <<<EOB

<!-- Section 9 -->
<section class="tpl__section section-9">
<div class="section-inner">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-0 col-sm-6 col-md-8 col-lg-8"></div>
      <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 padding-none">
        <div class="block block-title">
          <div class="block-inner">
            <h3>{$block->title}</h3>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-0 col-sm-6 col-md-8 col-lg-8 padding-none">
        <div class="block block-text">
          <div class="block-inner">
            <p>{$block->body}</p>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 padding-none">
        <div class="block block-image">
          <div class="block-inner">
              <div class="com__images com__image-resizable">
                <figure><img src="/images/image_section_9.jpg" alt=""></figure>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
<!-- end Section 9 -->

EOB;

    echo $blockHtml;

}