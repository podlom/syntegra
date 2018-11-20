<?php

/* @var $this \yii\web\View */
/* @var $meta common\models\Meta */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\models\Seometrics;
use common\widgets\Alert;
use common\helpers\LanguageHelper;


AppAsset::register($this);

$lang = 'ru';
if ($this->params && !empty($this->params["lang"])) {
    $lang = $this->params["lang"];
}

$websiteEmail = Yii::$app->settings->get('website', 'email' );
$websitePhone = $this->params['phone'];
$websiteLogo = Yii::$app->settings->get('website', 'logo', '/images/logo_header.png');

$title = isset($meta->title) ? $meta->title : $this->title;
$this->params['meta_image'] = isset($meta->meta_image) ? $meta->meta_image : $websiteLogo;
$this->params['og_image'] = isset($meta->og_image) ? $meta->og_image : $websiteLogo;
// $this->params['og_title'] = isset($meta->og_title) ? $meta->og_title : null;
// $this->params['og_description'] = isset($meta->og_description) ? $meta->og_description : null;

$defaultAddr = '';
switch ($this->params['langActive']) {
    case 'en':
        $fbAddr = Yii::$app->settings->get('social', 'facebook_en', 'https://www.facebook.com/uasyntegra');
        $lnAddr = Yii::$app->settings->get('social', 'linkedin_en', 'https://www.linkedin.com/company/syntegra-llc');
        // $twAddr = Yii::$app->settings->get('social', 'twitter_en', 'https://twitter.com/syntegra');
        // $gpAddr = Yii::$app->settings->get('social', 'googleplus_en', 'https://plus.google.com/+Syntegra');
        break;

    case 'ru':
    default:
        $fbAddr = Yii::$app->settings->get('social', 'facebook_ru', 'https://www.facebook.com/uasyntegra');
    $lnAddr = Yii::$app->settings->get('social', 'linkedin_ru', 'https://www.linkedin.com/company/syntegra-llc');
        // $twAddr = Yii::$app->settings->get('social', 'twitter_ru', 'https://twitter.com/syntegra');
        // $gpAddr = Yii::$app->settings->get('social', 'googleplus_ru', 'https://plus.google.com/+Syntegra');
        break;
}
$websiteAddress = Yii::$app->settings->get('website', 'address_' . strtolower($this->params["lang"]), $defaultAddr);

if (!empty($this->params['body_class'])) {
    $bodyClass = 'class="' . $this->params['body_class'] . '"';
}

if (empty($this->params['phone1'])) {
    $this->params['phone1'] = '+38 044 364 7779';
}
$currAction = Yii::$app->controller->action->id;
$currCtrl = Yii::$app->controller->id;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html class="js is-adaptive" lang="<?= Yii::$app->language ?>"
      xmlns:og="http://ogp.me/ns#"
      xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <?= Html::csrfMetaTags() ?>

        <title><?= Html::encode($title) ?></title>

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon" href="/favicon.ico">
        <link rel="apple-touch-icon" sizes="72x72" href="/favicon.ico">
        <link rel="apple-touch-icon" sizes="114x114" href="/favicon.ico">

        <?php

        if (!empty($meta->keywords)) {
            $this->registerMetaTag([
                'name' => 'keywords',
                'content' => Html::encode($meta->keywords),
            ]);
        }

        if (!empty($meta->description)) {
            $this->registerMetaTag([
                'name' => 'description',
                'content' => Html::encode($meta->description),
            ]);
        }

        if (!empty($this->params['meta_image'])) {
            if (!preg_match('|^' . Yii::$app->getRequest()->serverName . '|', $this->params['meta_image'])) {
                $this->params['meta_image'] = 'http://' . Yii::$app->getRequest()->serverName . $this->params['meta_image'];
            }
            echo '<link rel="image_src" href="' . Html::encode($this->params['meta_image']) . '">';
        }
        ?>
        <?= $this->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()]); ?>
        <meta property="og:url" content="<?= Url::canonical(); ?>" />
        <meta property="og:title" content="<?= Html::encode($this->params['og_title']) ?>" />
        <?php
        if (!empty($this->params['og_image'])) {
            if (!preg_match('|^' . Yii::$app->getRequest()->serverName . '|', $this->params['og_image'])) {
                $this->params['og_image'] = 'http://' . Yii::$app->getRequest()->serverName . $this->params['og_image'];
            }
            echo '<meta property="og:image" content="' . Html::encode($this->params['og_image']) . '" />';
        }
        ?>
        <meta property="og:description" content="<?= Html::encode($this->params['og_description']) ?>" />
        <meta property="og:type" content="website" />
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC0rVqJWw8X9JWyHZNOJAdI1KZqipiX_F0&language=<?= Yii::$app->language ?>"></script>
        <script src="/js/wow.min.js"></script>
        <script src="/js/app.min.js"></script>
        <?php $this->head() ?>
        <?= Seometrics::getValueBySlug('meta_tags'); ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    </head>

    <body <?=$bodyClass?>>

    <main class="main_wrapp">
        <header class="header">
            <div class="mod-lang">
                <div class="mod-lang__currlang mod-lang__currlang_<?= Yii::$app->language ?>">
                    <?= Yii::$app->language ?>
                </div>
                <div class="mod-lang__list">
                    <ul>
                        <?php
                        foreach (LanguageHelper::getSiteLanguages1() as $k=>$l){
                            echo '<li class="mod-lang__list-el';echo  strtolower(Yii::$app->language) == $k ? ' curr' : ''; echo '"><a href="/'.$k.'">'.strtoupper($k).'</a></li>';
                        }
                        ?>
                        <!--li class="mod-lang__list-el<?php echo strtolower(Yii::$app->language) == 'en' ? ' curr' : ''?>"><a href="/en">EN</a></li>

                        <li class="mod-lang__list-el<?php echo strtolower(Yii::$app->language) == 'ru' ? ' curr' : ''?>"><a href="/ru">RU</a></li-->
                    </ul>
                </div>
            </div>
            <div class="header__wrap">
                <div class="header__logo">
                    <a href="/">
                        <img src="<?= $websiteLogo ?>">
                    </a>
                </div>

                <nav class="header__nav-menu">
                    <ul class="header__menu">
                    <?php
                        echo $this->render('//site/_top-menu');
                    ?>
                    </ul>
                </nav>
                <div class="header__wr-logo">
                    <div class="header__get-in_touch">
                        <a class="open_modal" href="#modal1">GET IN TOUCH</a>
                        <div class="banner__skype">
                            <a href="skype:<?=$this->params['skype']?>?call"><?=$this->params['skype']?></a>
                        </div>
                    </div>
                    <div class="header__logo_microsoft">
                        <img src="/images/microsoft.png" id="firs_logo">
                        <img src="/images/microsoft-partner.png" id="two_logo">

                        <div class="banner__tel"><a href="tel:<?=$this->params['phone1']?>"><?=$this->params['phone1']?></a></div>
                    </div>
                </div>
            </div>


            <div class="header-wr__mobile">
                <div class="mobile__header-logo"><a href="/"><img src="/images/logo_header.png"></a></div>
                <div class="wr-left-block">
                    <div class="mobile-icon__menu">
                        <a class="icon-get-in-tach open_modal" href="#modal1"></a>
                        <a href="skype:<?=$this->params['skype']?>?call" class="icon-skype"></a>
                        <a href="tel:<?=$this->params['phone1']?>" class="icon-mobile-phone"></a>
                    </div>
                    <div class="burger-menu">
                        <div class="bar bar-icon-one"></div>
                        <div class="bar bar-icon-two"></div>
                        <div class="bar bar-icon-three"></div>
                    </div>
                </div>
            </div>
        </header>
            <nav class="mobile__header_nav-menu">
                <ul class="mobile_header__menu">
                    <?php
                    echo $this->render('//site/_top-menu');
                    ?>
                </ul>
            </nav>

        <?= $content ?>
        <div class="modal_overlay"></div>
        <?php
        $model = new \common\models\Contact();
        echo $this->render('//site/contact-back',['model'=>$model]);
        ?>
    </main>
    <?php $this->endBody() ?>

    <?= Seometrics::getValueBySlug('seo_metrics'); ?>

    </body>
</html>
<?php

$this->endPage();
