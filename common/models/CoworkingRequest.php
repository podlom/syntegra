<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "coworking_request".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $server
 * @property string $created_at
 */
class CoworkingRequest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coworking_request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email' /*, 'server' */], 'required'],
            [['server'], 'string'],
            [['created_at'], 'safe'],
            [['first_name', 'last_name'], 'string', 'max' => 55],
            [['email'], 'string', 'max' => 255],
            [['email'], 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'email' => Yii::t('app', 'Email'),
            'server' => Yii::t('app', 'Server'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }
}
