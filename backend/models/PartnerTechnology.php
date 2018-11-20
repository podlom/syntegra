<?php

namespace backend\models;

use common\models\Partner;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "partner_technology".
 *
 * @property int $id
 * @property int $partner_id
 * @property int $technology_id
 * @property string $lang
 * @property int $sort
 * @property int $published
 */
class PartnerTechnology extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partner_technology';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['partner_id', 'technology_id'], 'required'],
            [['partner_id', 'technology_id', 'sort', 'published'], 'integer'],
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
            'partner_id' => 'Partner ID',
            'technology_id' => 'Technology ID',
            'lang' => 'Lang',
            'sort' => 'Sort',
            'published' => 'Published',
        ];
    }

    public static function getPartners(){
           return ArrayHelper::map(Partner::find()->select(['id', 'CONCAT(title, " - ", lang) AS title'])->all(),'id','title');
    }
    public static function getTechnologies(){
        return ArrayHelper::map(Technologies::find()->select(['id', 'title'])->all(),'id','title');
    }

    public static function getPartnerName($id){
        return Partner::findOne($id);
    }
    public static function getTechnologyName($id){
        return Technologies::findOne($id);
    }

    public static function getTechnologiesByPartnerId($id){
        return (new Query())->
        from('technologies')->
        leftJoin('partner_technology','partner_technology.technology_id = technologies.id')->
        where(['partner_technology.partner_id'=>$id])
       // andWhere(['lang'=>Yii::$app->language])//->createCommand()->rawSql;
        ->all();
    }
}
