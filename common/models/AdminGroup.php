<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "admin_group".
 *
 * @property integer $id
 * @property string $name
 *
 * @property AdminUserGroup[] $adminUserGroups
 */
class AdminGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminUserGroups()
    {
        return $this->hasMany(AdminUserGroup::className(), ['group_id' => 'id']);
    }
}
