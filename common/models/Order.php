<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $client_id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $comment
 * @property string $status
 * @property string $total
 * @property string $currency_code
 * @property string $currency_value
 * @property string $ip
 * @property string $forwarded_ip
 * @property string $user_agent
 * @property string $lang
 * @property string $created_at
 * @property string $updated_at
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'email', 'first_name', 'last_name', 'phone', 'status', 'total', 'currency_value', 'ip', 'forwarded_ip', 'user_agent'], 'required'],
            [['client_id'], 'integer'],
            [['comment'], 'string'],
            [['total', 'currency_value'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['email'], 'string', 'max' => 254],
            [['first_name', 'last_name', 'phone'], 'string', 'max' => 32],
            [['status'], 'string', 'max' => 128],
            [['currency_code'], 'string', 'max' => 3],
            [['ip', 'forwarded_ip'], 'string', 'max' => 40],
            [['user_agent'], 'string', 'max' => 255],
            [['lang'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'client_id' => Yii::t('app', 'Client ID'),
            'email' => Yii::t('app', 'Email'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'phone' => Yii::t('app', 'Phone'),
            'comment' => Yii::t('app', 'Comment'),
            'status' => Yii::t('app', 'Status'),
            'total' => Yii::t('app', 'Total'),
            'currency_code' => Yii::t('app', 'Currency Code'),
            'currency_value' => Yii::t('app', 'Currency Value'),
            'ip' => Yii::t('app', 'Ip'),
            'forwarded_ip' => Yii::t('app', 'Forwarded Ip'),
            'user_agent' => Yii::t('app', 'User Agent'),
            'lang' => Yii::t('app', 'Lang'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
