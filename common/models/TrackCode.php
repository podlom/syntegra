<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "trackcodes".
 *
 * @property integer $id
 * @property string $value
 *
 */
class TrackCode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trackcodes';
    }

    /**
     * Get track code id. Add it to DB
     * @param $code
     * @return int
     */
    public static function getTrackCodeId($code)
    {
        //Cut for DB field length
        $code = substr($code, 0, 255);

        $_code = self::findOne(['value'=>$code]);

        if(empty($_code))
        {
            $_code = new TrackCode();
            $_code->value = $code;
            $_code->save();
        }

        return $_code->id;
    }


}
