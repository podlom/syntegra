<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 14.11.2017
 * Time: 17:44
 */
$i = 0;
if (!empty($imgFiles)) {
    $count = count($imgFiles);

   if ($count > 1) { ?>

       <div class="imgs-prod-thumb<?php echo ($count > 3 ? ' thumb-img-slider' : '');?>" >
    <?php
        foreach ($imgFiles as $img) {
            if (!is_array($img)) { ?>

                <div class="imgs-prod-thumb__item imgs-prod-thumb__item-<?= $i; ?>">
                    <div class="img-wr"><img src="<?= $img ?>" alt=""></div>
                </div>
                <?php
                $i++;
            } else {
                foreach ($img as $i2) { ?>
                    <div class="imgs-prod-thumb__item imgs-prod-thumb__item-<?= $i; ?>">
                        <div class="img-wr"><img src="<?= $i2 ?>" alt=""></div>
                    </div>
                    <?php
                    $i++;
                }
            }
        }
    ?>

       </div>
       <?php
       }
}
