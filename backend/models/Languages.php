<?php

namespace backend\models;


use Yii;

/**
 * This is the model class for table "languages".
 *
 * @property integer $id
 * @property string $name
 * @property string $short_name
 * @property integer $published
 * @property string $created_at
 * @property string $updated_at
 * @property integer $sort
 */
class Languages extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'languages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['name', 'short_name'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['published', 'sort'], 'integer'],
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
            'short_name' => Yii::t('app', 'Short Name'),
            'published' => Yii::t('app', 'Published'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'sort' => Yii::t('app', 'Sort Order'),
        ];
    }
}
