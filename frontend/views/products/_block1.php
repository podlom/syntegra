<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 07.08.2017
 */


/* @var $block common\models\Block */

if (!empty($block)) {

    $blockHtml = <<<EOB

          <!-- Section 7 -->
          <section class="tpl__section section-7">
            <div class="section-inner">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-xs-0 col-sm-6 col-md-9 col-lg-9"></div>
                  <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 padding-none">
                    <div class="block block-bathroom_decor">
                      <div class="block-inner">
                        <h3>{$block->title}</h3>
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
              <div class="container-fluid">
                <div class="row">
                  <div class="col-xs-0 col-sm-0 col-md-0 col-lg-2"></div>
                  <div class="col-xs-12 col-sm-6 col-md-9 col-lg-7 padding-left">
                    <div class="block block-text">
                      <div class="block-inner">
                        {$block->body}
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 padding-none">
                    <div class="block block-images">
                      <div class="block-inner">
                          <div class="com__images com__image-resizable">
                            <figure><img src="/images/image_section_8.jpg" alt=""></figure>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>

EOB;

    echo $blockHtml;

}