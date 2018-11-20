<?php

namespace common\components;

use Yii;
use yii\base\Component;

class Websockets extends Component
{
    public $host;
    public $port;
    public $scope;

    public function clientUrl()
    {
        return sprintf('%s://%s/websockets/%s',
            Yii::$app->request->getIsSecureConnection() ? 'wss' : 'ws',
            Yii::$app->request->serverName,
            $this->scope
        );
    }

    public function broadcast($data)
    {
        return $this->post($this->url(), $data);
    }

    public function send($id, $data)
    {
        if (empty($id)) {
            throw new Exception('ID is not specified');
            
        }
        $url = sprintf('%s/%s', $this->url(), $id);
        return($this->post($url, $data));
    }

    private function post($url, $data)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        curl_exec($ch);

        if (curl_errno($ch)) {
            Yii::error('Web sockets: <![CDATA[errorCode:' . curl_errno($ch) . '; errorMessage:' . curl_error($ch) . ']]>', __METHOD__);
        }

        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($status_code == 200) {
            return true;
        }

        return false;
    }

    private function url()
    {
        if (empty($this->host) || empty($this->port) || empty($this->scope)) {
            throw new \Exception(sprintf('Component %s is not configuired properly', get_class($this)));
        }
        return sprintf('http://%s:%s/%s', $this->host, $this->port, $this->scope);
    }
}
