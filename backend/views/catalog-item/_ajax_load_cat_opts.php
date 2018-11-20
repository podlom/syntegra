<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 31.05.2017
 * Time: 17:50
 */

if (!empty($options)) {
    $optsHtml = '';
    foreach ($options as $o1) {
        $optsHtml .= '<option value="' . $o1['id'] . '">' . $o1['title'] . '</option>';
    }
    $optsHtml .= '';

    echo $optsHtml;
}