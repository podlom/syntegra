<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "trackcode_clicks".
 *
 * @property string $click_hash
 * @property string $date
 * @property integer $trackcode_id
 * @property string $referer
 * @property string $request_uri
 * @property integer $ip
 * @property string $user_hash
 */
class TrackCodeClick extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trackcode_clicks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['click_hash', 'date', 'trackcode_id', 'ip', 'user_hash'], 'required'],
            [['date'], 'safe'],
            [['trackcode_id', 'ip'], 'integer'],
            [['click_hash', 'user_hash'], 'string', 'max' => 32],
            [['referer', 'request_uri'], 'string', 'max' => 1024]
        ];
    }

    /**
     * Convert ip2long and set
     *
     * @var string $ip
     */
    public function setIp($ip)
    {
        $this->ip = ip2long($ip);
    }
}
