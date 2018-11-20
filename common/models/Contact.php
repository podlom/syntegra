<?php

namespace common\models;


use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "contact".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $message
 * @property string $server
 * @property string $created_at
 */
class Contact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact';
    }


    /**
     * Поведения модели
     * @return array
     */
    public function behaviors()
    {
        return [
            // автозаполнение полей created_at и updated_at
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => [],
                ],
                'value' => function () {return date('Y-m-d H:i:s');},
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'message', 'server'], 'required'],
            [['message', 'server'], 'string'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['email'], 'string', 'max' => 255],
            ['email', 'email'],
            ['name', 'match', 'pattern' => '/^[A-ZА-Я][a-z а-я]*$/ui'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'message' => Yii::t('app', 'Message'),
            'server' => Yii::t('app', 'Server'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }
}
