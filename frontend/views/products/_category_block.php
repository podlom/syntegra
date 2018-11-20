<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 19.07.2017
 */

/* @var $block common\models\Block */

$bHtml = '';
if (!empty($block)) {
    $bHtml = <<<EOB

<!-- Block -->

{$block->body}

<!-- end Block -->

EOB;

}

echo $bHtml;