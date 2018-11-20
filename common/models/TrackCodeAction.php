<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "trackcode_actions".
 *
 * @property string $click_hash
 * @property integer $user_id
 * @property string $date
 * @property string $action
 */
class TrackCodeAction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trackcode_actions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['click_hash', 'user_id', 'date', 'action'], 'required'],
            [['user_id'], 'integer'],
            [['date'], 'safe'],
            [['click_hash'], 'string', 'max' => 32],
            [['action'], 'string', 'max' => 10]
        ];
    }
}
