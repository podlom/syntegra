<?php

namespace console\controllers;


use Yii;
use yii\base\InvalidParamException;
use yii\console\Controller;
use common\models\CatalogItem;
use common\models\CatalogCategory;
use common\models\CatalogItemVariant;
use common\models\CatalogColor;
use common\models\CatalogSubcategory1;
use common\models\CatalogSubcategory2;
use common\models\CatalogSubcategory3;
use common\models\CatalogSubcategory4;
use common\models\Meta;


/**
 * Catalog commands
 */
class CatalogController extends Controller
{
    /**
     * Import catalog items, create catalog categories from CSV
     * @param $lang String Language ru|en|uk
     * @return Integer Status code
     */
    public function actionImportCatalog($lang)
    {
        $langOk = ['ru', 'en', 'uk'];
        $fileName = Yii::getAlias('@console') . DIRECTORY_SEPARATOR .
            'runtime' . DIRECTORY_SEPARATOR .
            'data' . DIRECTORY_SEPARATOR .
            $lang . '.csv';

        if (empty($lang)) {
            echo 'Command usage: yii cron/import-catalog language' . PHP_EOL;
            return 1;
        }

        if (!in_array($lang, $langOk)) {
            echo "Wrong lang value " . var_export($lang, 1) . " possible values are: " . var_export($langOk, 1) . PHP_EOL;
            return 2;
        }

        if (!file_exists($fileName)) {
            echo "File: " . $fileName . " does not exists!" . PHP_EOL;
            return 3;
        }

        echo "Parse file name: " . $fileName . PHP_EOL;
        $skus = $cats = $width = $height = $quantity = $weight = $montage_way = $title = [];
        $row = 1;
        if (($handle = fopen($fileName, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 40960, ";")) !== FALSE) {
                $num = count($data);
                echo "{$num} fields in line {$row}:" . PHP_EOL;

                // $checkData = mb_convert_encoding(trim($data[7]), "utf-8", "windows-1251");
                // $checkData = mb_convert_encoding(trim($data[7]), "windows-1251", "utf-8");
                $checkData = trim($data[7]);
                $sku = strtoupper(substr($checkData, 0, 8));
                if ($row >= 2) {
                    if (!in_array($sku, $skus)) {
                        $skus[] = $sku;
                        // $cats[$sku] = mb_convert_encoding(trim($data[0]), "windows-1251", "utf-8");
                        // $cats[$sku] = mb_convert_encoding(trim($data[0]), "utf-8", "windows-1251");
                        $title[$sku] = trim($data[8]);
                        $cats[$sku] = trim($data[0]);
                        $width[$sku] = trim($data[15]);
                        $height[$sku] = trim($data[16]);
                        $quantity[$sku] = trim($data[12]);
                        $weight[$sku] = trim($data[19]);
                        $montage_way[$sku] = trim($data[21]);
                    }
                }

                $row ++;

                /* if (count($skus) == 500) {
                    break;
                } */
            }
            fclose($handle);
        }
        echo 'Parsed catalog items: ' . var_export($skus, 1) . PHP_EOL;
        echo 'Parsed categories: ' . var_export($cats, 1) . PHP_EOL;

        if (!empty($skus)) {
            
            foreach ($skus as $n => $sku) {

                if(!$width[$sku]){
                    $width[$sku] = 0;
                }
                if(!$height[$sku]){
                    $height[$sku] = 0;
                }
                if(!$weight[$sku]){
                    $weight[$sku] = 0;
                }
                if (empty($title[$sku])
                    && empty($cats[$sku])
                    && empty($width[$sku])
                    && empty($height[$sku])
                    && empty($quantity[$sku])
                    && empty($weight[$sku])
                    && empty($montage_way[$sku])
                ) {
                    continue;
                }

                // SELECT id, category_id, published, created_at, updated_at, lang, sort, sku, width, height, quantity, weight, montage_way FROM catalog_item
                $caIt = CatalogItem::find()
                    ->select('id, category_id, published, created_at, updated_at, lang, sort, sku, width, height, quantity, weight, montage_way')
                    ->where([
                        'lang' => $lang,
                        'sku' => $sku
                    ])->asArray()
                    ->all();
                if (empty($caIt)) {
                    // insert catalog item
                    $category_id = $sort = 0;
                    $published = 1;

                    // prepare data to insert
                    $ciSo = CatalogItem::findBySql("SELECT MAX(sort)+1 AS new_sort FROM catalog_item WHERE lang='{$lang}'")
                        ->asArray()
                        ->one();
                    // echo 'Catalog item sort: ' . print_r($ciSo, 1) . PHP_EOL;
                    $sort = intval($ciSo['new_sort']);
                    // echo 'Catalog item sort: ' . $sort . PHP_EOL;

                    // echo 'Category: ' . print_r($cats[$sku], 1) . PHP_EOL;
                    $caCa = CatalogCategory::find()
                        ->where([
                            'lang' => $lang,
                            'name' => $cats[$sku],
                        ])->asArray()
                        ->all();
                    if (empty($caCa)) {
                        $maxSort = CatalogCategory::findBySql("SELECT MAX(sort)+1 AS new_sort FROM catalog_category WHERE lang='{$lang}'")
                            ->asArray()
                            ->one();
                        echo 'Max category sort: ' . print_r($maxSort, 1) . PHP_EOL;

                        $cSort = 0;
                        if($maxSort['new_sort']){
                            $cSort = $maxSort['new_sort'];
                        }

                        // Add new catalog category
                        $newCa = new CatalogCategory();
                        $newCa->name = $cats[$sku];
                        $newCa->published = 1;
                        $newCa->lang = $lang;
                        $newCa->sort = $cSort;
                        $newCa->created_at = date('Y-m-d H:i:s');
                        $newCa->updated_at = date('Y-m-d H:i:s');
                        if ($newCa->validate()) {
                            $newCa->save();
                        } else {
                            echo 'Error create catalog category errors: ' . var_export($newCa->getErrors(), 1) . PHP_EOL;
                            continue;
                        }
                    } else {
                        // echo 'Catalog category for SKU: ' . $sku . ' ID is: ' . print_r($caCa, 1) . PHP_EOL;
                        $category_id = intval($caCa[0]['id']);
                        echo 'Catalog category ID #' . $category_id . ' for SKU: ' . $sku . PHP_EOL;
                    }

                    // «составной» товар (группа товаров)
                    $skuSuffix = '';
                    if (preg_match('прямой', $title[$sku])) {
                        $skuSuffix = '-k';
                    }
                    if (preg_match('гибкий', $title[$sku])) {
                        $skuSuffix = '-g';
                    }
                    //
                    echo 'Insert new catalog item with SKU: ' . $sku . PHP_EOL . print_r($caIt, 1) . PHP_EOL;
                    $newCi = new CatalogItem();
                    $newCi->category_id = $category_id;
                    $newCi->published = $published;
                    $newCi->created_at = date('Y-m-d H:i:s');
                    $newCi->updated_at = date('Y-m-d H:i:s');
                    $newCi->lang = $lang;
                    $newCi->sort = $sort;
                    $newCi->sku = $sku . $skuSuffix;
                    $newCi->title = $title[$sku];
                    $newCi->width = str_replace(',', '.', $width[$sku]);
                    $newCi->height = str_replace(',', '.', $height[$sku]);
                    $newCi->quantity = $quantity[$sku];
                    $newCi->weight = str_replace(',', '.', $weight[$sku]);
                    $newCi->montage_way = $montage_way[$sku];
                    if ($newCi->validate()) {
                        $newCi->save();
                    } else {
                        echo 'Error create catalog item errors: ' . var_export($newCi->getErrors(), 1) . PHP_EOL;
                        continue;
                    }

                } else {
                    // TODO: update existing catalog item
                    echo 'Update existing catalog item with SKU: ' . $sku . PHP_EOL . print_r($caIt, 1) . PHP_EOL;
                }
            }
        }

        return 0;
    }

    /**
     * Import catalog item variants from CSV
     * @param $lang String Language ru|en|uk
     * @return Integer Status code
     */
    public function actionImportCatalogVariants($lang)
    {
        $langOk = ['ru', 'en', 'uk'];
        $fileName = Yii::getAlias('@console') . DIRECTORY_SEPARATOR .
            'runtime' . DIRECTORY_SEPARATOR .
            'data' . DIRECTORY_SEPARATOR .
            $lang . '.csv';

        if (empty($lang)) {
            echo 'Command usage: yii cron/import-catalog-variants language' . PHP_EOL;
            return 1;
        }

        if (!in_array($lang, $langOk)) {
            echo "Wrong lang value " . var_export($lang, 1) . " possible values are: " . var_export($langOk, 1) . PHP_EOL;
            return 2;
        }

        if (!file_exists($fileName)) {
            echo "File: " . $fileName . " does not exists!" . PHP_EOL;
            return 3;
        }

        echo "Parse file name: " . $fileName . PHP_EOL;

        $skus = $color_id = $img_url = $length = [];
        $articul_1c = $articul_epicentr = [];
        $sub_category1_id = $sub_category2_id = $sub_category3_id = $sub_category4_id = [];
        $title = $descr = $description_short = $price = [];
        //
        $row = 1;
        if (($handle = fopen($fileName, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 40960, ";")) !== FALSE) {
                $num = count($data);
                echo "{$num} fields in line {$row}:" . PHP_EOL;
                //$sku = strtoupper(substr($checkData, 0, 8));
                $articul = trim(strtoupper($data[7]));
                if ($row >= 2) {
                    if (!in_array($articul, $skus)) {
                        $skus[] = $articul;
                        //
                        // default, color_id, img_url, sort,
                        // published, created_at, updated_at, length,
                        // articul_1c, articul_epicentr,
                        // sub_category1_id, sub_category2_id, sub_category3_id, sub_category4_id,
                        // title, descr, description_short, lang, price
                        //
                        $color_id[$articul] = trim($data[13]);
                        $length[$articul] = trim($data[14]);
                        $articul_1c[$articul] = trim($data[5]);
                        $articul_epicentr[$articul] = trim($data[6]);
                        $sub_category1_id[$articul] = trim($data[1]);
                        $sub_category2_id[$articul] = trim($data[2]);
                        $sub_category3_id[$articul] = trim($data[3]);
                        $sub_category4_id[$articul] = trim($data[4]);
                        $title[$articul] = trim($data[8]);
                        $descr[$articul] = trim($data[9]);
                        $description_short[$articul] = trim($data[10]);
                        $price[$articul] = trim($data[11]);
                    }
                }

                $row ++;

                /* if (count($skus) == 500) {
                    break;
                } */
            }
            fclose($handle);
        }

        echo 'Parsed item variants: ' . var_export($skus, 1) . PHP_EOL;
        echo 'Color ids: ' . var_export($color_id, 1) . PHP_EOL;
        // echo 'Lengths: ' . var_export($length, 1) . PHP_EOL;
        // return 0;

        foreach ($skus as $articul) {

            if(!$length[$articul]){
                $length[$articul] = 0;
            }
            if(!$price[$articul]){
                $price[$articul] = 0;
            }

            if (empty($color_id[$articul])
                && empty($length[$articul])
                && empty($articul_1c[$articul])
                && empty($articul_epicentr[$articul])
                && empty($sub_category1_id[$articul])
                && empty($sub_category2_id[$articul])
                && empty($sub_category3_id[$articul])
                && empty($sub_category4_id[$articul])
                && empty($title[$articul])
                && empty($descr[$articul])
                && empty($description_short[$articul])
                && empty($price[$articul])
            ) {
                continue;
            }

            $cIv = CatalogItemVariant::find()
                ->select('id, default, color_id, img_url, sort, published, created_at, updated_at, length, articul_1c, articul_epicentr, sub_category1_id, sub_category2_id, sub_category3_id, sub_category4_id, title, descr, description_short, lang, price')
                ->where(['articul' => $articul, 'lang' => $lang])
                ->asArray()
                ->all();

            // echo print_r($cIv, 1) . PHP_EOL;
            // return 0;

            if (isset($cIv[0]['id'])) {
                // TODO: update catalog item variants logic
                echo 'Need to update catalog item variant: ' . print_r($cIv, 1) . PHP_EOL;
                echo 'New length: ' . $length[$articul] . PHP_EOL;
                die();
            } else {
                $default = 1;
                echo 'Catalog item variant with aricul ' . $articul . ' was not found.' . PHP_EOL;
                $sku = substr($articul, 0, 8);
                $deDa = CatalogItemVariant::findBySql("SELECT `id`, `default` FROM `catalog_item_variant` WHERE `default` = 1 AND `lang` = '{$lang}' AND `articul` LIKE '{$sku}%'")
                    ->asArray()
                    ->one();
                // echo 'Default data: ' . var_export($deDa, 1) . PHP_EOL;
                // return 0;
                if (isset($deDa['id'])) {
                    $default = 0;
                }

                $sort = 1;
                $soDa = CatalogItemVariant::findBySql("SELECT MAX(sort) + 1 AS new_sort FROM `catalog_item_variant` WHERE `lang` = '{$lang}' AND `articul` LIKE '{$sku}%'")
                    ->asArray()
                    ->one();
                // echo 'New sort data: ' . var_export($soDa, 1) . PHP_EOL;
                // return 0;
                if (isset($soDa['new_sort'])) {
                    $sort = intval($soDa['new_sort']);
                    if ($sort == 0) {
                        $sort = 1;
                    }
                }

                $color = CatalogColor::find()
                    ->select('*')
                    ->where([
                        'lang' => $lang,
                        'title' => $color_id[$articul]
                    ])
                    ->asArray()
                    ->one();
                if (isset($color['id'])) {
                    echo 'Found color: ' . var_export($color, 1) . PHP_EOL;
                } else {
                    $nColor = new CatalogColor();
                    $nColor->title = $color_id[$articul];
                    $nColor->lang = $lang;
                    $nColor->published = 1;
                    if ($nColor->validate()) {
                        $nColor->save();
                    }  else {
                        echo 'Error create catalog color: ' . var_export($nColor->getErrors(), 1) . PHP_EOL;
                        continue;
                    }
                }
                // echo 'Color: ' . var_export($color, 1) . PHP_EOL;

                $subCat1 = $subCat2 = $subCat3 = $subCat4 = 0;
                for ($i = 1; $i <= 4; $i++) {
                    $varName = 'sCat' . $i;
                    $sCat = CatalogSubcategory1::find()
                        ->select('*')
                        ->where(['lang' => $lang, 'title' => $sub_category1_id[$articul]])
                        ->asArray()
                        ->one();
                    // echo 'Sub category #' . $i . ': ' . var_export($$varName, 1) . PHP_EOL;
                    if (isset($sCat['id'])) {
                        $v2n = 'subCat' . $i;
                        $$v2n = $sCat['id'];
                    }
                }

                $product_id = 0;
                $caIt = CatalogItem::findBySql("SELECT `id` FROM `catalog_item` WHERE `lang` = '{$lang}' AND `sku` = '{$sku}'")
                    ->asArray()
                    ->one();
                if (isset($caIt['id'])) {
                    $product_id = intval($caIt['id']);
                }

                $caItVa = new CatalogItemVariant();
                $caItVa->product_id = $product_id;
                $caItVa->default = $default;
                $caItVa->color_id = $color['id'];
                $caItVa->img_url = '/images/product/' . $articul . '.jpg';
                $caItVa->sort = $sort;
                $caItVa->published = 1;
                $caItVa->created_at = date('Y-m-d H:i:s');
                $caItVa->updated_at = date('Y-m-d H:i:s');
                $caItVa->length = $length[$articul];
                $caItVa->articul = $articul;
                $caItVa->articul_1c = $articul_1c[$articul];
                $caItVa->articul_epicentr = $articul_epicentr[$articul];
                $caItVa->sub_category1_id = intval($subCat1);
                $caItVa->sub_category2_id = intval($subCat2);
                $caItVa->sub_category3_id = intval($subCat3);
                $caItVa->sub_category4_id = intval($subCat4);
                $caItVa->title = $title[$articul];
                $caItVa->descr = $descr[$articul];
                $caItVa->description_short = $description_short[$articul];
                $caItVa->lang = $lang;
                $caItVa->price = str_replace(',', '.', $price[$articul]);
                // echo 'Create new catalog item variant. ' . PHP_EOL;
                if ($caItVa->validate()) {
                    $caItVa->save();
                } else {
                    echo 'Error create catalog item variant: ' . var_export($caItVa->getErrors(), 1) . PHP_EOL;
                    continue;
                }
            }
        }

        return 0;
    }

    /**
     * Import catalog items SEO meta from CSV
     * @param $lang String Language ru|en|uk
     * @return Integer Status code
     */
    public function actionImportCatalogMeta($lang)
    {
        $langOk = ['ru', 'en', 'uk'];
        $fileName = Yii::getAlias('@console') . DIRECTORY_SEPARATOR .
            'runtime' . DIRECTORY_SEPARATOR .
            'data' . DIRECTORY_SEPARATOR .
            $lang . '.csv';

        if (empty($lang)) {
            echo 'Command usage: yii cron/import-catalog-meta language' . PHP_EOL;
            return 1;
        }

        if (!in_array($lang, $langOk)) {
            echo "Wrong lang value " . var_export($lang, 1) .
                " possible values are: " . var_export($langOk, 1) . PHP_EOL;
            return 2;
        }

        if (!file_exists($fileName)) {
            echo "File: " . $fileName . " does not exists!" . PHP_EOL;
            return 3;
        }

        echo "Parse file name: " . $fileName . PHP_EOL;

        $skus = $seo_titles = $seo_descrs = $seo_keywords = [];
        //
        $row = 1;
        if (($handle = fopen($fileName, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 40960, ";")) !== FALSE) {
                $num = count($data);
                echo "{$num} fields in line {$row}:" . PHP_EOL;

                $articul = trim($data[7]);
                if ($row >= 2) {
                    if (!in_array($articul, $skus)) {
                        $skus[] = $articul;
                        //
                        $seo_titles[$articul] = trim($data[24]);
                        $seo_descrs[$articul] = trim($data[25]);
                        $seo_keywords[$articul] = trim($data[26]);
                    }
                }

                $row ++;

                /* if (count($skus) == 500) {
                    break;
                } */
            }
            fclose($handle);
        }

        echo 'Parsed item variants: ' . var_export($skus, 1) . PHP_EOL;
        // echo 'SEO titles: ' . var_export($seo_titles, 1) . PHP_EOL;
        // echo 'SEO descriptions: ' . var_export($seo_descrs, 1) . PHP_EOL;
        // echo 'SEO keywords: ' . var_export($seo_keywords, 1) . PHP_EOL;

        foreach ($skus as $articul) {
            $sku = substr($articul, 0, 8);
            $urlPrefix = '/' . $lang;
            if ($lang == 'ru') { $urlPrefix = ''; }
            $urlPat = $urlPrefix . '/products/view/' . strtolower($sku);

            $sql = "SELECT * FROM `meta` WHERE `url` LIKE '{$urlPat}%' AND `lang` = '{$lang}'";
            echo 'SQL: ' . $sql . PHP_EOL;

            $meta = \common\models\Meta::findBySql($sql)
                ->asArray()
                ->all();
            if (empty($meta)) {
                // TODO: insert meta information
                $nM = new Meta();
                $nM->url = $urlPat;
                $nM->lang = $lang;
                $nM->title = $seo_titles[$articul];
                $nM->og_title = $seo_titles[$articul];
                $nM->description = $seo_descrs[$articul];
                $nM->og_description = $seo_descrs[$articul];
                $nM->keywords = $seo_keywords[$articul];
                $nM->published = 1;
                $nM->created_at = date('Y-m-d H:i:s');
                $nM->updated_at = date('Y-m-d H:i:s');
                if ($nM->validate()) {
                    $nM->save();
                } else {
                    echo 'Error create catalog item meta: ' . var_export($nM->getErrors(), 1) . PHP_EOL;
                    continue;
                }
            } else {
                // TODO: update meta information
                echo 'Found meta: ' . var_export($meta, 1) . PHP_EOL;
            }


        }

        return 0;
    }

    /**
     * Unpublish category empty items by category
     * @param $lang String Language ru|en|uk
     * @return Integer Status code
     */
    public function actionUnpublishEmptyCategoryItems($lang)
    {
        $langOk = ['ru', 'en', 'uk'];

        if (empty($lang)) {
            echo 'Command usage: yii cron/unpublish-empty-category-items lang' . PHP_EOL;
            return 1;
        }

        if (!in_array($lang, $langOk)) {
            echo "Wrong lang value " . var_export($lang, 1) .
                " possible values are: " . var_export($langOk, 1) . PHP_EOL;
            return 2;
        }

        $sql = "SELECT * FROM catalog_category WHERE published = 1 AND lang = '{$lang}'";

        $category = CatalogCategory::findBySql($sql)
            ->asArray()
            ->all();

        foreach ($category as $cat) {
            // echo print_r($cat, 1) . PHP_EOL;
            echo 'Checking not published catalog item variants in category #' . $cat['id'] . ' ' . $cat['name'] . PHP_EOL;

            $categoryId = $cat['id'];

            $sql2 = "SELECT ci.id FROM catalog_item ci LEFT JOIN catalog_item_variant civ ON civ.product_id = ci.id WHERE ci.category_id = '{$categoryId}' AND ci.published = 1 AND civ.published = 0 GROUP BY ci.id HAVING COUNT(civ.id) > 0";

            $catalogItem = CatalogItem::findBySql($sql2)
                ->asArray()
                ->all();
            $catItemId = [];
            if (!empty($catalogItem)) {
                foreach ($catalogItem as $it) {
                    $catItemId[] = $it['id'];
                }
            }

            if (!empty($catItemId)) {
                $strIds = implode(', ', $catItemId);

                $sql3 = "UPDATE catalog_item SET published = 0 WHERE id IN ($strIds) AND published = 1";
                $command = Yii::$app->db->createCommand($sql3);
                $result = $command->execute();

                echo 'Updated rows: ' . print_r($result, 1) . PHP_EOL;
            }
        }
    }

    /**
     * Unpublish empty categories
     * @param $lang String Language ru|en|uk
     * @return Integer Status code
     */
    public function actionUnpublishEmptyCategories($lang)
    {
        $langOk = ['ru', 'en', 'uk'];

        if (empty($lang)) {
            echo 'Command usage: yii cron/unpublish-empty-categories lang' . PHP_EOL;
            return 1;
        }

        if (!in_array($lang, $langOk)) {
            echo "Wrong lang value " . var_export($lang, 1) .
                " possible values are: " . var_export($langOk, 1) . PHP_EOL;
            return 2;
        }

        $sql = "SELECT * FROM catalog_category WHERE published = 1 AND lang = '{$lang}'";

        $category = CatalogCategory::findBySql($sql)
            ->asArray()
            ->all();

        foreach ($category as $cat) {
            // echo print_r($cat, 1) . PHP_EOL;
            echo 'Checking not published catalog item variants in category #' . $cat['id'] . ' ' . $cat['name'] . PHP_EOL;

            $sql2 = "
			
SELECT cc.id, cc.name, COUNT(ci.id) AS cnt1, (

SELECT COUNT(ci2.id) FROM catalog_category cc2 
LEFT JOIN catalog_item ci2 ON ci2.category_id = cc2.id
WHERE cc2.published = 1 AND cc2.lang = '{$lang}' AND ci2.published = 0 AND cc.id = cc2.id

) AS cnt2
  FROM catalog_category cc 
LEFT JOIN catalog_item ci ON ci.category_id = cc.id
WHERE cc.published = 1 AND cc.lang = '{$lang}'
GROUP BY cc.id
;
			
			";

            $checkCategory = CatalogCategory::findBySql($sql2)
                ->asArray()
                ->all();

            if (!empty($checkCategory)) {
                foreach ($checkCategory as $chCat) {
                    if ($chCat['cnt1'] == $chCat['cnt2']) {
                        echo 'Unpublishing category: ' . print_r($chCat, 1) . PHP_EOL;

                        $sql3 = "UPDATE catalog_category SET published = 0 WHERE id = '{$chCat['id']}' AND published = 1";
                        $command = Yii::$app->db->createCommand($sql3);
                        $result = $command->execute();

                        echo 'Unpublished category result: ' . print_r($result, 1) . PHP_EOL;
                    }
                }
            }
        }
    }
}
