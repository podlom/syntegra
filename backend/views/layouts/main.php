<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;


AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <?php $this->head() ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
</head>

<body class="blank-page">
<?php $this->beginBody() ?>
<div id="main">
<!-- Start: Header-->
      <header class="navbar navbar-shadow flexbox align-items-center undefined">
        <div class="navbar-branding"><a href="/site/index" class="navbar-brand"><?= $this->params['companyName'] ?> Admin</a><span id="toggle_sidemenu_l" class="fa fa-align-left"></span></div>
        <ul class="nav navbar-nav navbar-left veil reveal-lg-flex">
          <li class="flexbox align-items-center">

            <div style="float:right !important;">
              <a data-method="post" href="<?=Url::to(['site/logout'])?>">Logout</a>
            </div>
          </li>
        </ul>

      </header>
      <!-- Start: Sidebar-->
      <aside id="sidebar_left" class="nano nano-light affix">
        <!-- Start: Sidebar Left Content-->
        <div class="sidebar-left-content nano-content">

          <!-- Sidebar Widget - Search (hidden)-->
          <div class="sidebar-widget search-widget hidden">
            <div class="input-group"><span class="input-group-addon"><i class="fa fa-search"></i></span>
              <input id="sidebar-search" type="text" placeholder="Search..." class="form-control"/>
            </div>
          </div>
          <ul class="nav sidebar-menu">
            <li class="sidebar-label"></li>
            <li class="sidebar-menu-item"><a id="homePageLink" href="/site/index"><span class="glyphicon glyphicon-home"></span><span class="sidebar-title">Dashboard</span></a>
            </li>
            <li class="sidebar-menu-item"><a href="#" class="accordion-toggle"><span class="fa fa-flash"></span><span class="sidebar-title">Content</span></a>
              <ul class="nav sub-nav">
                <!--li><a href="/catalog-category/index"><span class="glyphicon glyphicon-credit-card"></span>Categories</a></li>
                <li><a href="/catalog-item/index"><span class="glyphicon glyphicon-shopping-cart"></span>Products</a></li>
                <li><a href="/catalog-item-variant/index"><span class="glyphicon glyphicon-credit-card"></span>Product Variants</a></li>
                <li><a href="/catalog-item-image/index"><span class="glyphicon glyphicon-picture"></span>Product Images</a></li-->
                <li><a href="/page/index"><span class="glyphicon glyphicon-duplicate"></span>Pages</a></li>
                <li><a href="/news/index"><span class="glyphicon glyphicon-equalizer"></span>News</a></li>
                <li><a href="/questions/index"><span class="glyphicon glyphicon-equalizer"></span>Questions</a></li>
                <!--li><a href="/slide/index"><span class="glyphicon glyphicon-shopping-cart"></span>Slides</a></li-->

              </ul>
            </li>
            <li class="sidebar-menu-item"><a href="#" class="accordion-toggle"><span class="fa fa-check-square"></span><span class="sidebar-title">SEO Parameters</span></a>
              <ul class="nav sub-nav">
                <li><a href="/meta/index"><span class="fa fa-desktop"></span>SEO Meta</a></li>
                <li><a href="/seometrics/index"><span class="fa fa-clipboard"></span>SEO Metrics</a></li>
              </ul>
            </li>
            <li class="sidebar-menu-item"><a href="#" class="accordion-toggle"><span class="fa fa-cog"></span><span class="sidebar-title">Settings</span></a>
              <ul class="nav sub-nav">
                <li><a href="/menu/index">Menu</a></li>
                <li><a href="/settings/default/index">Settings</a></li>
                <li><a href="/error-log/index">Error log</a></li>
              </ul>
            </li>

          </ul>
          <!-- Start: Sidebar Collapse Button-->
          <div class="sidebar-toggle-mini"><a href="#"><span class="fa fa-sign-out"></span></a></div>
        </div>
      </aside>
      <!-- Start: Content-Wrapper-->
      <section id="content_wrapper">
        <!-- Start: Topbar-Dropdown-->
        <div id="topbar-dropmenu" class="alt">
          <div class="topbar-menu row">
            <div class="col-xs-4 col-sm-2"><a href="#" class="metro-tile bg-primary light"><span class="glyphicon glyphicon-inbox text-muted"></span><span class="metro-title">Messages</span></a></div>
            <div class="col-xs-4 col-sm-2"><a href="#" class="metro-tile bg-info light"><span class="glyphicon glyphicon-user text-muted"></span><span class="metro-title">Users</span></a></div>
            <div class="col-xs-4 col-sm-2"><a href="#" class="metro-tile bg-success light"><span class="glyphicon glyphicon-headphones text-muted"></span><span class="metro-title">Support</span></a></div>
            <div class="col-xs-4 col-sm-2"><a href="#" class="metro-tile bg-system light"><span class="glyphicon glyphicon-facetime-video text-muted"></span><span class="metro-title">Videos</span></a></div>
            <div class="col-xs-4 col-sm-2"><a href="#" class="metro-tile bg-warning light"><span class="fa fa-gears text-muted"></span><span class="metro-title">Settings</span></a></div>
            <div class="col-xs-4 col-sm-2"><a href="#" class="metro-tile bg-alert light"><span class="glyphicon glyphicon-picture text-muted"></span><span class="metro-title">Pictures</span></a></div>
          </div>
        </div>
        <!-- Start: Topbar-->
        <header id="topbar" class="hidden">
          <div class="topbar-left">
            <ol class="breadcrumb">
              <li class="crumb-active"><a href="/site/index">Dashboard</a></li>
              <li class="crumb-icon"><a href="/site/index"><span class="glyphicon glyphicon-home"></span></a></li>
              <li class="crumb-link"><a href="/site/index">Home</a></li>
              <li class="crumb-trail">Dashboard</li>
            </ol>
          </div>
          <div class="topbar-right">
            <div class="ib topbar-dropdown">
              <label for="topbar-multiple" class="control-label pr10 fs11 text-muted">Reporting Period</label>
              <select id="topbar-multiple" class="hidden">
                <optgroup label="Filter By:">
                  <option value="1-1">Last 30 Days</option>
                  <option value="1-2" selected="selected">Last 60 Days</option>
                  <option value="1-3">Last Year</option>
                </optgroup>
              </select>
            </div>
            <div id="toggle_sidemenu_r" class="ml15 ib va-m"><a href="#" class="pl5"><i class="fa fa-sign-in fs22 text-primary"></i><span class="badge badge-hero badge-danger">3</span></a></div>
          </div>
        </header>
        <!-- Begin: Content-->
        <section id="content" class="animated fadeIn">
          <!-- Demo Text Content-->
          <div class="pl15 pr50">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
          </div>
        </section>
      </section>
      <!-- Start: Right Sidebar-->
      <aside id="sidebar_right" class="nano affix">
        <!-- Start: Sidebar Right Content-->
        <div class="sidebar-right-content nano-content p15">
          <h5 class="title-divider text-muted mb20">Server Statistics<span class="pull-right">2013<i class="fa fa-caret-down ml5"></i></span></h5>
          <div class="progress mh5">
            <div role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 44%" class="progress-bar progress-bar-primary"><span class="fs11">DB Request</span></div>
          </div>
          <div class="progress mh5">
            <div role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 84%" class="progress-bar progress-bar-info"><span class="fs11 text-left">Server Load</span></div>
          </div>
          <div class="progress mh5">
            <div role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 61%" class="progress-bar progress-bar-warning"><span class="fs11 text-left">Server Connections</span></div>
          </div>
          <h5 class="title-divider text-muted mt30 mb10">Traffic Margins</h5>
          <div class="row">
            <div class="col-xs-5">
              <h3 class="text-primary mn pl5">132</h3>
            </div>
            <div class="col-xs-7 text-right">
              <h3 class="text-success-dark mn"><i class="fa fa-caret-up"></i> 13.2%</h3>
            </div>
          </div>
          <h5 class="title-divider text-muted mt25 mb10">Database Request</h5>
          <div class="row">
            <div class="col-xs-5">
              <h3 class="text-primary mn pl5">212</h3>
            </div>
            <div class="col-xs-7 text-right">
              <h3 class="text-success-dark mn"><i class="fa fa-caret-up"></i> 25.6%</h3>
            </div>
          </div>
          <h5 class="title-divider text-muted mt25 mb10">Server Response</h5>
          <div class="row">
            <div class="col-xs-5">
              <h3 class="text-primary mn pl5">82.5</h3>
            </div>
            <div class="col-xs-7 text-right">
              <h3 class="text-danger mn"><i class="fa fa-caret-down"></i> 17.9%</h3>
            </div>
          </div>
          <h5 class="title-divider text-muted mt40 mb20">Server Statistics<span class="pull-right text-primary fw600">USA</span></h5>
        </div>
      </aside>
    </div>
</div>


<?php $this->endBody() ?>

<?php

$this->registerJs("

    jQuery(document).ready(function () {
        'use strict';
        // Init Demo JS
        Demo.init();
        // Init Theme Core
        Core.init();
    });

", \yii\web\View::POS_END);

?>

</body>
</html>
<?php $this->endPage() ?>
