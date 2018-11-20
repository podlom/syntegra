<?php

$bottomMenu = '';
if (!empty($this->params['menu2'])) {

    $bottomMenu .= '<ul class="footer__menu">';

    foreach ($this->params['menu2'] as $n => $tmi) {
        $bottomMenu .= '<li>
                        <a href="' . $tmi['url'] . '">' . $tmi['title'] . '</a>
                     </li>';
    }
    $bottomMenu .= '</ul>';
}


$bottomMenu1 = '';
if (!empty($this->params['menu3'])) {

    $bottomMenu1 .= '<ul class="menu-info">';

    foreach ($this->params['menu3'] as $n => $tmi) {
        $bottomMenu1 .= '<li>
                        <a href="' . $tmi['url'] . '">' . $tmi['title'] . '</a>
                     </li>';
    }
    $bottomMenu1 .= '</ul>';
}

$bottomMenu2 = '';
if (!empty($this->params['menu4'])) {



    foreach ($this->params['menu4'] as $n => $tmi) {
        $bottomMenu2 .= '
                        <a href="' . $tmi['url'] . '">' . $tmi['title'] . '</a>
                     ';
    }

}

$bottomMenu3 = '';
if (!empty($this->params['menu5'])) {



    foreach ($this->params['menu5'] as $n => $tmi) {
        $bottomMenu3 .= '
                        <a href="' . $tmi['url'] . '">' . $tmi['title'] . '</a>
                     ';
    }

}

//echo $bottomMenu;

?>
<section class="section section_business">
    <div class="section_content__wrapp wow fadeInUp">
        <h5 class="section_business__title">Ready to take your business to new heights?</h5><a class="banner__btn_yellow open_modal" href="#modal1">Contact Us</a>
    </div>
</section>
<footer class="footer">
    <div class="section_content__wrapp">
        <div class="footer_cont-wr">
            <div class="wr-row menu">
                <div class="footer__logo"><img src="/images/footer_logo.png"></div>
                <div class="footer_nav__menu">
                   <?=$bottomMenu?>
                </div>
            </div>
            <div class="wr-row content">
                <div class="flex-col">
                    <p class="footer-text">In a world where the pace of change is constantly increasing, how do you take control of your business?</p>
                    <p class="footer-text">Adapt faster.Syntegra provides the data consultancy you need to transform your business into a DataDriven enterprise that can respond quickly to change.</p>
                    <p class="adress">Ukraine, Kiev, 04078, Sergey Danchenko, 8</p>
                </div>
                <div class="flex-col footer-link"><?=$bottomMenu2?></div>
                <div class="flex-col footer-link"><?=$bottomMenu3?></div>
            </div>
        </div>
    </div>
    <div class="wr-row align-items-center">
        <div class="banner__contact">
            <div class="banner__skype">
                <a href="skype:<?=$this->params['skype']?>?call" class="banner__skype-link"><?=$this->params['skype']?></a>
                <a href="skype:<?=$this->params['skype']?>?call" class="banner__skype-link__mobile icon-skype"></a>
            </div>
            <div class="banner__tel">
                <a href="tel:<?=$this->params['phone1']?>" class="banner__tel-link"><?=$this->params['phone1']?></a>
                <a href="tel:<?=$this->params['phone1']?>" class="banner__tel-link__mobile icon-icon-mobile-phone"></a>
            </div>
        </div>
        <div class="wrapp_menu-info">
            <?=$bottomMenu1?>
            <div class="copyright">Copyright © 2017 Syntegra, Inc.  All Rights Reserved</div>
        </div>
    </div>
    <div class="footer_by_wdss">
        <p><a class="wdsscopy" href="http://wdss.com.ua" target="_blank">created by WD&SS</a></p>
        <p class="wdss_cont">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </div>
</footer>