<?php

namespace frontend\models;


use Yii;
use yii\base\Model;

class SurveyForm extends Model
{
    public $comments;

    public function rules()
    {
        return [
           // [['comments'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
           // 'verifyCode' => 'Verification Code',
            //'body' => 'Message',
        ];
    }

}

