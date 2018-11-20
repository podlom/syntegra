<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 13.11.2017
 * Time: 12:17
 */

namespace console\controllers;


use common\models\CatalogItem;
use common\models\CatalogItemVariant;
use Yii;
use yii\console\Controller;


class UpdateCatalogController extends Controller
{

    /**
     * Import catalog item variants from CSV
     * @param $lang String Language ru|en|uk
     * @return Integer Status code
     */
    public function actionUpdateCatalogItemVariants($lang)
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

        $aliases = [
            'Категория',
            'Под категория',
            'Под категория2',
            'Под категория3',
            'Под категория4',
            'Артикул 1С',
            'Артикул Эпицентр',
            'Артикул Брас Лайн',
            'Наименование',
            'Подробное описание',
            'Краткое описание',
            'Цена',
            'Кол-во на складе',
            'цвет',
            'Длина',
            'Ширина',
            'Толщина',
            'Поверхность',
            'Теоретичний периметр счения проиля (мм)',
            'Теоретический вес 1 м.п. профил (кг)',
            'Упаковка',
            'Способ монтажа',
            'Перекрестные товары',
            'ATTACHMENT',
            'SEOTITLE',
            'SEODESC',
            'SEOKW',
        ];
        //
        // Direct mappings from import file data to catalog_item_variant table columns
        $alias2dbFields = [
            1 => 'sub_category1_id',
            2 => 'sub_category2_id',
            3 => 'sub_category3_id',
            4 => 'sub_category4_id',
            5 => 'articul_1c',
            6 => 'articul_epicentr',
            7 => 'articul',
            14 => 'length',
        ];
        //
        // TODO: convert color name to color_id using linked parent product_id
        // TODO: generate img_url using articul part to lowercase plus .jpg
        //
        $cols = [];
        $row = 1;
        if (($handle = fopen($fileName, "r")) !== FALSE) {
            while (($cols = fgetcsv($handle, 40960, ";")) !== FALSE) {
                $num = count($cols);
                echo "{$num} fields in line {$row}:" . PHP_EOL;
                break;
                // exit;
            }
            fclose($handle);
        }
        //
        $cols2aliases = [];
        if (!empty($cols)) {
            foreach ($cols as $n1 => $c1) {
                if (in_array($c1, $aliases)) {
                    $kAlias = array_search($c1, $aliases);
                    $cols2aliases[$n1] = $kAlias;
                    // echo 'Column #' . $n1 . ': ' . $c1 . ' is in aliases key: ' . $kAlias . PHP_EOL;
                } else {
                    echo 'Column #' . $n1 . ': ' . $c1 . ' was not found in aliases ' . PHP_EOL;
                }
            }
        }
        if (!empty($cols2aliases)) {
            echo 'Cols to aliases mapping: ' . var_export($cols2aliases, 1) . PHP_EOL;
        }
        //
        $cols = $sku = [];
        $row = 1;
        if (($handle = fopen($fileName, "r")) !== FALSE) {
            while (($cols = fgetcsv($handle, 40960, ";")) !== FALSE) {
                if ($row > 1) {
                    // echo 'Row #' . $row . ' data: ' . var_export($cols, 1) . PHP_EOL;
                    $trData = trim($cols[ $cols2aliases[7] ]);
                    if (!empty($trData)) {
                        $sku[] = $trData;
                    }
                }
                if ($row > 750) {
                    break;
                }
                $row ++;
            }
            fclose($handle);
        }
        //
        if (!empty($sku)) {
            echo var_export($sku, 1) . PHP_EOL;
        }
        //
    }

    public function actionCreateCatalogItemFromVariant($prodVarId)
    {
        if (empty($prodVarId)) {
            echo 'Command usage: yii cron/create-catalog-item-from-variant prodVarId' . PHP_EOL;
            return 1;
        }

        $prodVar = CatalogItemVariant::findOne(['id' => $prodVarId]);

        if (!empty($prodVar)) {
            // echo '$prodVar: ' . print_r($prodVar, 1) . PHP_EOL;

            $prodVarParent = CatalogItem::findOne(['id' => $prodVar->product_id]);
            // echo '$prodVarParent: ' . print_r($prodVarParent, 1) . PHP_EOL;

            $newSort = $prodVarParent->sort + 1;
            // $createdDbDateTime = date('Y-m-d H:i:s');
            $catIt = new CatalogItem();
            $catIt->title = $prodVar->title;
            $catIt->category_id = $prodVarParent->category_id;
            $catIt->descr = $prodVar->descr;
            $catIt->published = 1;
            // $catIt->created_at = $createdDbDateTime;
            // $catIt->updated_at = $createdDbDateTime;
            $catIt->lang = $prodVarParent->lang;
            $catIt->sort = $newSort;
            //
            $catIt->sku = $prodVarParent->sku . '-1';
            //
            $catIt->width = $prodVarParent->width;
            $catIt->height = $prodVarParent->height;
            $catIt->sub_category1_id = $prodVarParent->sub_category1_id;
            $catIt->sub_category2_id = $prodVarParent->sub_category2_id;
            $catIt->sub_category3_id = $prodVarParent->sub_category3_id;
            $catIt->sub_category4_id = $prodVarParent->sub_category4_id;
            $catIt->description_short = $prodVarParent->description_short;
            $catIt->quantity = $prodVarParent->quantity;
            $catIt->surface = $prodVarParent->surface;
            $catIt->weight = $prodVarParent->weight;
            $catIt->montage_way = $prodVarParent->montage_way;
            if ($catIt->validate()) {
                if ($catIt->save()) {
                    echo 'Saved new CatalogItem().' . PHP_EOL;
                }
            } else {
                echo 'Errors validating new CatalogItem(): ' . print_r($catIt->getErrors(), 1) . PHP_EOL;
            }
        }
    }
}