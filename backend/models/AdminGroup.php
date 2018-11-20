<?php
namespace backend\models;


use Yii;
use common\models\AdminGroup as CommAdminGroup;


/**
 * This is the backend model class for table "admin_group".
 *
 * @property integer $id
 * @property string $name
 *
 * @property AdminUserGroup[] $adminUserGroups
 */
class AdminGroup extends CommAdminGroup
{

}