<?php
/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 15.05.2017
 * Time: 13:18
 */

namespace backend\helpers;


use yii\helpers\ArrayHelper;
use common\models\CatalogColor;


class CatalogColorHelper
{
    public static function getColors()
    {
        static $data = null;

        if ($data === null) {
            $data = [];
            $catalogColor = CatalogColor::findAll(['published' => 1]);
            if (!empty($catalogColor)) {
                $data = ArrayHelper::map($catalogColor, 'id', 'title');
            }
        }

        return $data;
    }

    public static function getColorById($id)
    {
        $colorData = CatalogColor::findOne(['id' => $id, 'published' => 1]);

        if (!empty($colorData)) {
            return $colorData;
        }
    }
}