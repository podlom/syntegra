<?php

/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 03.05.2017
 * Time: 10:27
 */

namespace backend\helpers;


use common\models\AdminUserGroup;


class UserHelper
{
    const ADMIN_GROUP_ID = 1;
    const EDITOR_GROUP_ID = 2;

    public static function isAdmin($userId)
    {
        $userId = intval($userId);

        $user = AdminUserGroup::findOne(['user_id' => $userId]);

        if (!empty($user)) {
            if ($user->group_id == self::ADMIN_GROUP_ID) {
                return true;
            }
        }

        return false;
    }

    public static function isEditor($userId)
    {
        $userId = intval($userId);

        $user = AdminUserGroup::findOne(['user_id' => $userId]);

        if (!empty($user)) {
            if ($user->group_id == self::EDITOR_GROUP_ID) {
                return true;
            }
        }

        return false;
    }
}
