<?php

namespace console\controllers;


use Yii;
use yii\console\Controller;
use common\models\CatalogItem;
use common\models\CatalogItemVariant;
use yii\db\Exception;


/**
 * Catalog image helper commands
 */
class CatalogImageController extends Controller
{

    /**
     * Verify & add missing product images
     */
    public function actionVerifyImages()
    {
        $srcImgDir = Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR .
            'web' . DIRECTORY_SEPARATOR .
            'images' . DIRECTORY_SEPARATOR .
            'i1' . DIRECTORY_SEPARATOR;

        $dstImgDir = Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR .
            'web' . DIRECTORY_SEPARATOR .
            'images' . DIRECTORY_SEPARATOR .
            'product' . DIRECTORY_SEPARATOR;

        echo 'Checking missing images in: ' . $srcImgDir . ' to ' . $dstImgDir . PHP_EOL;

        $imgDst = glob($dstImgDir . '*.{jpg,JPG}', GLOB_BRACE);
        $cId = count($imgDst);
        if ($cId) {
            echo 'Found ' . $cId . ' in ' . $dstImgDir . ' folder '. PHP_EOL;
        }

        $imgSrc = glob($srcImgDir . '*.{jpg,JPG}', GLOB_BRACE);
        $cIs = count($imgSrc);
        if ($cIs) {
            echo 'Found ' . $cIs . ' in ' . $srcImgDir . ' folder '. PHP_EOL;

            $cOk = $cErr = $j = 0;
            foreach ($imgSrc as $i) {
                /* if ($j == 7) {
                    break;
                } */
                $art = substr($i, strlen($srcImgDir) + 1, -4);
                echo 'Checking image ' . $i . ' Checking articul: '  . $art . PHP_EOL;

                $civQuery = CatalogItemVariant::find()
                    ->where(['published' => 1]);
                $civ = $civQuery->andFilterWhere(['like', 'img_url', $art])
                    ->asArray()
                    ->all();

                // echo 'Found: ' . print_r($civ, 1) . PHP_EOL;
                if (!empty($civ[0]['img_url'])) {
                    $bsDst = basename($civ[0]['img_url']);
                    echo 'Checking destination file: ' . $dstImgDir . $bsDst . PHP_EOL;
                    if (file_exists($dstImgDir . $bsDst)) {
                        echo 'Skip destination file exists: ' . $dstImgDir . $bsDst . PHP_EOL;
                    } else {
                        if (copy($i, $dstImgDir . $bsDst)) {
                            echo 'Copied ' . $i . ' to ' . $dstImgDir . $bsDst . PHP_EOL;
                            $cOk ++;
                        } else {
                            echo 'Error: can`t copy ' . $i . ' to ' . $dstImgDir . $bsDst . PHP_EOL;
                            $cErr ++;
                        }
                    }
                }
                $j ++;
            }
        }
        $imgDst2 = glob($dstImgDir . '*.{jpg,JPG}', GLOB_BRACE);
        $cId2 = count($imgDst2);
        if ($cId2) {
            echo 'Found ' . $cId2 . ' in ' . $dstImgDir . ' folder '. PHP_EOL;
        }
        echo 'Checked ' . $j . ' image files. Copied ' . $cOk . ' images. Image copy errors: ' . $cErr . PHP_EOL;
    }

    /**
     * Fix wrong product image names
     */
    public function actionFixImageNames()
    {
        $prodImgDir = Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR .
            'web' . DIRECTORY_SEPARATOR .
            'images' . DIRECTORY_SEPARATOR .
            'product' . DIRECTORY_SEPARATOR;
        // $prImgs = glob($prodImgDir . '*.{jpg,JPG}', GLOB_BRACE);
        $prImgs = glob($prodImgDir . '*.{jpg}', GLOB_BRACE);
        $c = count($prImgs);
        $y = $x = $r = $n = 0;
        if ($c > 0) {
            foreach ($prImgs as $img) {
                $bN = basename($img);
                $art = substr($bN, 0, -4);
                if (strlen($art) > 16) {
                    $art = substr($art, 0, 16);
                }
                if ($n <= 16 || $n == 19 || $n == 85 || $n == 159) {
                    echo 'Skipped image ' . $n . '...' . PHP_EOL;
                    $n ++;
                    continue;
                }
                echo 'Checking image (' . $n . '): ' . $bN . ' check articul: ' . $art . PHP_EOL;

                $civQuery = CatalogItemVariant::find()
                    ->where(['published' => 1]);
                $civ = $civQuery->andFilterWhere(['like', 'img_url', $art])
                    ->asArray()
                    ->one();
                if (!empty($civ['img_url'])) {
                    // echo 'Found CIV: ' . var_export($civ, 1) . PHP_EOL;
                    $bNok = basename($civ['img_url']);
                    if ($bNok != $bN) {
                        echo 'Base name OK: ' . $bNok . ' != ' . $bN . PHP_EOL;

                        $oldName = $prodImgDir . $bN;
                        $newName = $prodImgDir . $bNok;
                        if (file_exists($newName)) {
                            echo 'Destination file exists: ' . $newName . PHP_EOL;
                            $x ++;
                        } else {
                            try {
                                $oldName = escapeshellarg($oldName);
                                $newName = escapeshellarg($newName);
                                if (rename($oldName, $newName)) {
                                    echo 'Renamed image from: ' . $bN . ' to: ' . $bNok . PHP_EOL;
                                    $r ++;
                                }
                            } catch (Exception $e) {
                                echo 'Caught exception: ',  $e->getMessage(), PHP_EOL;
                                continue;
                            }
                        }
                        
                    } else {
                        $y ++;
                    }
                }
                $n ++;
            }
            echo 'Renamed ' . $r . ' images. Good names: ' . $y . '. Images exists: ' . $x . '.' . PHP_EOL;
        }
    }

    /**
     * Fix product images extension register
     */
    public function actionFixImageNamesRegister()
    {
        $prodImgDir = Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR .
            'web' . DIRECTORY_SEPARATOR .
            'images' . DIRECTORY_SEPARATOR .
            'product' . DIRECTORY_SEPARATOR;
        $prImgs = glob($prodImgDir . '*.{JPG}', GLOB_BRACE);
        $c = count($prImgs);
        $r = $n = 0;
        if ($c > 0) {
            echo 'Found ' . $c . ' with wrong extenstion in uppercase...' . PHP_EOL;
            foreach ($prImgs as $img) {
                $bN = basename($img);
                $art = substr($bN, 0, 16);
                echo 'Checking image (' . $n . '): ' . $bN . ' check articul: ' . $art . PHP_EOL;
                $civQuery = CatalogItemVariant::find()
                    ->where(['published' => 1]);
                $civ = $civQuery->andFilterWhere(['like', 'img_url', $art])
                    ->asArray()
                    ->one();
                if (!empty($civ)) {
                    $fixedImgUrl = '/images/product/' . $art . '.jpg';
                    echo 'Fixed img_url: ' . $fixedImgUrl .' Found by articul pattern: ' . $art . ' :' . print_r($civ, 1) . PHP_EOL;
                    $oCv = CatalogItemVariant::findOne([
                        'id' => $civ['id'],
                        'published' => 1,
                    ]);
                    if (!empty($oCv)) {
                        $oCv->img_url = $fixedImgUrl;
                        $oCv->save();
                        //
                        $bNok = basename($fixedImgUrl);
                        //
                        $oldName = escapeshellarg($prodImgDir . DIRECTORY_SEPARATOR . $bN);
                        $newName = escapeshellarg($prodImgDir . DIRECTORY_SEPARATOR . $bNok);
                        try {
                            if (rename($oldName, $newName)) {
                                echo 'Renamed image from: ' . $bN . ' to: ' . $bNok . PHP_EOL;
                                $r ++;
                            }
                        } catch (Exception $e) {
                            echo 'Caught exception: ',  $e->getMessage(), PHP_EOL;
                            continue;
                        }
                    }
                }
                $n ++;
            }
            echo 'Renamed ' . $r . ' images.' . PHP_EOL;
        }
    }

    /**
     * Generate images report
     * @param $lang String Language ru|en|uk
     * @return Integer Status code
     */
    public function actionImgReport($lang)
    {
        $langOk = ['ru', 'en', 'uk'];

        if (empty($lang)) {
            echo 'Command usage: yii catalog-image/img-report language' . PHP_EOL;
            return 1;
        }

        if (!in_array($lang, $langOk)) {
            echo "Wrong lang value " . var_export($lang, 1) . " possible values are: " . var_export($langOk, 1) . PHP_EOL;
            return 2;
        }

        $dstImgDir = Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR .
            'web' . DIRECTORY_SEPARATOR .
            'images' . DIRECTORY_SEPARATOR .
            'product' . DIRECTORY_SEPARATOR;

        $lng = \Yii::$app->db->quoteSql($lang);
        $sql = "SELECT civ.id, civ.product_id, ci.category_id AS category_id, cc.name AS category_name, civ.articul, civ.img_url, civ.lang 
FROM catalog_item_variant civ 
INNER JOIN catalog_item ci ON ci.id = civ.product_id 
INNER JOIN catalog_category cc ON cc.id = ci.category_id
WHERE civ.published = 1 AND civ.lang = '{$lng}' AND ci.lang = '{$lng}' AND cc.lang = '{$lng}' AND ci.published = 1 AND cc.published = 1
ORDER BY civ.id";
        $civ = CatalogItemVariant::findBySql($sql)
            ->asArray()
            ->all();
        $k = 0;
        $foundImg = $imgOk = $noImg = $notFound = $catName = [];
        if (!empty($civ)) {
            $cnt = count($civ);
            echo 'Found published ' . $cnt . ' in language ' . $lang . PHP_EOL;
            foreach ($civ as $a) {
                if (!empty($a['img_url'])) {
                    /* if ($k == 14) {
                        break;
                    } */
                    $bN = basename($a['img_url']);
                    echo 'Checking file ' . $bN . ' in folder: ' . $dstImgDir . PHP_EOL;
                    if (file_exists($dstImgDir . $bN)) {
                        if (!isset($imgOk[$a['category_id']])) {
                            $imgOk[$a['category_id']] = 1;
                        } else {
                            $imgOk[$a['category_id']] += 1;
                        }
                        if (!isset($foundImg[$a['category_id']])) {
                            $foundImg[$a['category_id']] = [];
                        }
                        array_push($foundImg[$a['category_id']], $bN);
                    } else {
                        if (!isset($noImg[$a['category_id']])) {
                            $noImg[$a['category_id']] = 1;
                        } else {
                            $noImg[$a['category_id']] += 1;
                        }
                        if (!isset($notFound[$a['category_id']])) {
                            $notFound[$a['category_id']] = [];
                        }
                        array_push($notFound[$a['category_id']], $bN);
                    }
                    if (!isset($catName[$a['category_id']])) {
                        $catName[$a['category_id']] = $a['category_name'];
                    }
                    $k ++;
                }
            }
        }
        $logFile = Yii::getAlias('@console') . DIRECTORY_SEPARATOR . 'runtime' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'img-report-' . $lang . '-' . date('Y-m-d-H-i'). '.log';
        $sumOkImg = array_sum($imgOk);
        $sumNoImg = array_sum($noImg);
        file_put_contents($logFile,
            'Category names: ' . var_export($catName, 1) . PHP_EOL .
            'Checked ' . $k . ' images OK (' . $sumOkImg . '): ' . var_export($imgOk, 1) . PHP_EOL .
            'Found images: ' . var_export($foundImg, 1) . PHP_EOL .
            'No Images (' . $sumNoImg . '): ' . var_export($noImg, 1) . PHP_EOL .
            'Not found images: ' . var_export($notFound, 1) . PHP_EOL
        );
        echo 'Category names: ' . var_export($catName, 1) . PHP_EOL;
        echo 'Checked ' . $k . ' images OK (' . $sumOkImg . '): ' . var_export($imgOk, 1) . PHP_EOL;
        echo 'No Images (' . $sumNoImg . '): ' . var_export($noImg, 1) . PHP_EOL;
        echo 'Detailed log written to file: ' . $logFile . PHP_EOL;
    }

    /**
     * Unpublish catalog items without images
     */
    public function actionUnpublishNoImg()
    {
        $imgDir = Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'web';

        $civ = CatalogItemVariant::find()
            ->where(['published' => 1])
            ->asArray()
            ->all();

        $unPublish = $foundImg = $notFound = [];
        $foundImg['ru'] = $foundImg['uk'] = $foundImg['en'] = 0;
        $notFound['ru'] = $notFound['uk'] = $notFound['en'] = 0;
        $unPublish['ru'] = $unPublish['uk'] = $unPublish['en'] = 0;
        foreach ($civ as $iv) {
            echo 'Checking id #' . $iv['id'] . '; lang: ' . $iv['lang'] . '; img: ' . $iv['img_url'] . PHP_EOL;
            $imgPathFull = $imgDir . $iv['img_url'];
            if (file_exists($imgPathFull)) {
                $foundImg[$iv['lang']] += 1;
            } else {
                $notFound[$iv['lang']] += 1;
                //
                $oCiv = CatalogItemVariant::find()
                    ->where([
                        'id' => intval($iv['id']), 
                        'published' => 1,
                    ])
                    ->one();
                if (!empty($oCiv)) {
                    $oCiv->published = 0;
                    if ($oCiv->save()) {
                        $unPublish[$iv['lang']] += 1;
                        echo 'Saved ' . print_r($oCiv, 1) . PHP_EOL;
                    } else {
                        echo 'Error saving ' . print_r($oCiv, 1) . PHP_EOL;
                    }
                } else {
                    echo 'Can`t find item by id ' . var_export(intval($iv['id']), 1) . PHP_EOL;
                    continue;
                }
            }
        }
        echo 'Found images: ' . var_export($foundImg, 1) . '. Not found images: ' . var_export($notFound, 1) . '. Unpublished: ' . var_export($unPublish, 1) . PHP_EOL;
    }

    /**
     * Unpublish catalog items by not published variants
     */
    public function actionUnpublishItems()
    {
        $civ = CatalogItemVariant::find()
            ->where(['published' => 0])
            ->asArray()
            ->all();

        if (!empty($civ)) {
            foreach ($civ as $ci) {
                $oCi = CatalogItem::findOne(['id' => $ci['product_id'], 'published' => 1]);
                if (!empty($oCi)) {
                    $oCi->published = 0;
                    $oCi->save();
                    echo 'Unpublished catalog item id: ' . $ci['product_id'] . PHP_EOL;
                }
            }
            
        }
    }

    /**
     * Publish catalog items with images
     */
    public function actionPublishWighImg()
    {
        $imgDir = Yii::getAlias('@frontend') . DIRECTORY_SEPARATOR . 'web';
        $sql = "SELECT ci.id, ci.category_id, cc.name AS category_name, cc.lang, ci.published, ci.sku, civ.articul, civ.img_url
FROM catalog_item ci 
LEFT JOIN catalog_item_variant civ ON civ.product_id = ci.id
LEFT JOIN catalog_category cc ON cc.id = ci.category_id
WHERE ci.published = 0";
        $items = CatalogItemVariant::findBySql($sql)
            ->asArray()
            ->all();
        if (!empty($items)) {
            $i = $j = 0;
            foreach ($items as $it) {
                // echo print_r($it, 1) . PHP_EOL;
                $imgPathFull = $imgDir . $it['img_url'];
                if (file_exists($imgPathFull)) {
                    echo 'File exists: ' . $imgPathFull . PHP_EOL;
                    $j ++;

                    $ci = CatalogItem::findOne(['id' => $it['id'], 'published' => 0]);
                    if (!empty($ci)) {
                        $ci->published = 1;
                        $ci->save();
                    }
                }
                $i ++;
            }
            echo 'Checked ' . $i . ' items. Found ' . $j . ' items with images.' . PHP_EOL;
        }
    }
}