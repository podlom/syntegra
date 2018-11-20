<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "questions".
 *
 * @property integer $id
 * @property string $json_data
 * @property integer $id_group
 * @property string $created_at
 * @property string $updated_at
 */
class Answers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['json_data'], 'string'],
            [['id_question'], 'integer'],
            [['created_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'json_data' => 'Json Data',
            'id_question' => 'Id Question',
            'created_at' => 'Created At'
        ];
    }


}
