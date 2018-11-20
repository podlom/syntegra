<?php

namespace backend\models;


use Yii;
use yii\web\UploadedFile;


/**
 * This is the model class for table "questions".
 *
 * @property integer $id
 * @property string $title
 * @property string $json_data
 * @property integer $id_group
 * @property string $created_at
 * @property string $updated_at
 * @property string $image
 * @property string $lang
 */
class Questions extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['json_data'], 'string'],
            [['title', 'image'], 'string'],
            [['id_group'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['id_group'], 'exist', 'skipOnError' => false, 'targetClass' => GroupQuestions::className(), 'targetAttribute' => ['id_group' => 'id']],
            [['id_group'], 'default', 'value' => 1],
            [['lang'], 'string', 'max' => 2],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'json_data' => 'Json Data',
            'id_group' => 'Id Group',
            'image' => 'File',
            'upload' => 'Download File',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'lang' => Yii::t('app', 'Lang'),
        ];
    }


    public function getGroupQuestions(){
        //var_dump($this->hasOne(GroupQuestions::className(), ['id'=>'id_group']));die();
        return $this->hasOne(GroupQuestions::className(), ['id'=>'id_group']);
    }



}
