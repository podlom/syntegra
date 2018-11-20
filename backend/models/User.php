<?php
namespace backend\models;

use Yii;
use common\models\User as ComUser;

/**
 * Extended common\models\User
 *
 * This allows us to do "Yii::$app->user->something" by adding getters
 * like "public function getSomething()"
 *
 * So we can use variables and functions directly in `Yii::$app->user`
 */
class User extends ComUser
{
    public function getUsername()
    {
        // return Yii::$app->user->identity->username;
        $user = User::findOne(Yii::$app->user->identity->id);
        if (!empty($user)) {
        	return $user->username;
        }
    }
}