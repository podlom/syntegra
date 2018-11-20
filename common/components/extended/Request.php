<?php

namespace common\components\extended;

class Request extends \yii\web\Request
{
    /**
     * Add check for getIsSecureConnection
     * @return boolean if the request is sent via secure channel (https)
     */
    public function getIsSecureConnection()
    {
        if(isset($_SERVER['HTTP_X_SCHEME'])) {
            return (strcasecmp($_SERVER['HTTP_X_SCHEME'], 'https') === 0);
        }

        return parent::getIsSecureConnection();
    }

}