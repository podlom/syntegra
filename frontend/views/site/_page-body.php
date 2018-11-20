<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 31.05.2017
 * Time: 12:31
 */

/* @var $page common\models\Page */

if (!empty($page)) {
    echo $page->body;
} else {
    echo '<!-- About Us Page is empty! -->';
}
