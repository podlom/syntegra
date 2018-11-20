<?php
use frontend\helpers\SliderHelper;
use frontend\helpers\MenuHelper;

//var_dump($this->params['menu1']);die;
$lang = Yii::$app->language;



/*
if($lang == 'ru'){
    $pages = MenuHelper::getSubMenu(2, $lang);
    $sub_id = 3;
}
if($lang == 'en'){
    $pages = MenuHelper::getSubMenu(4, $lang);
    $sub_id = 3;
}
$page = '';
$imgs = '';
$industries = '';
$pages1 = MenuHelper::getSubMenu(3, $lang);
if(!empty($pages1)) {
    foreach ($pages1 as $p) {
        $industries .= '<li><a href="/page/' . $p->slug . '">' . $p->title . '</a></li>';
    }
}

if(!empty($pages)) {
    foreach ($pages as $p) {
        $page .= '<li>
                        <a href="/page/' . $p->slug . '">' . $p->title . '</a>
                        <ul class="dropdown-menu-services-item">
                              '. $industries.'
                        </ul>
                  </li>';
        $imgs .= '<div class="ddmenu-it-img" style="background-image: url('.$p->img_url.');"></div>';
    }
}
*/
$menu1 = MenuHelper::getSubMenuBySlug('services', $lang);
//var_dump($menu1);die;
$menu_html = '';
if(!empty($menu1)){
    $menu_html .= '<div class="dropdown-menu">
                  <div class="menu-col-1">
                    <ul class="dropdown-menu-services">';
                        foreach ($menu1 as $m1){
                            $menu_html .=  '  <li><a href="/page/'.$m1->slug.'">'.$m1->title.'</a>
                                <ul class="dropdown-menu-services-item">';
                            $menu2 = MenuHelper::getSubMenuBySlug($m1->slug, $lang);
                            if(!empty($menu2)){
                                foreach ($menu2 as $m2){
                                    $menu_html .=  '<li><a href="/page/'.$m2->slug.'">'.$m2->title.'</a></li>';

                                }
                            }
                            $menu_html .= '</ul>
                              </li>';
                        }


    $menu_html .=  '
                    </ul>
                  </div>
                  <div class="menu-col-2"></div>
                  <div class="menu-col-3">';
    foreach ($menu1 as $m1) {
        $menu_html .=  '
                    <div class="ddmenu-it-img" style="background-image: url('.$m1->img_url.');"></div>';
    }


    $menu_html .=  '                 </div>
                </div>';
}



$img='';

if (!empty($this->params['menu1'])) {

    foreach ($this->params['menu1'] as $n => $tmi) { ?>
       <li>
            <a href="<?= $tmi['url']?>"><?= $tmi['title']?></a>
           <?php
            if($tmi['url'] == '/services'){
                echo $menu_html;
            } ?>
        </li>
<?php
    }
}
