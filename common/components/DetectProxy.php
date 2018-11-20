<?php

namespace common\components;

use Yii;

class DetectProxy extends \yii\base\Component {

    public $proxyUrl = '';

    public $proxyTimeout = 1;

    public $headers = [];

    //Domain list from config
    public $domains = [];

    private $redirectUrl = false;

    private $proxyDetectorRewrite = false;

    public function init()
    {
        parent::init();

        //Set in frontend/web/proxy-detector.php. Used if call ping.png or ping.js
        $this->proxyDetectorRewrite = defined('PROXY-DETECTOR-REWRITE');

        if ( !$this->is_white_ip(Yii::$app->request->getUserIP()) && $this->is_proxy_request($this->proxyUrl) ) {

            if ($this->is_need_redirect()) {
                Yii::error('Redirect <![CDATA['.$this->redirectUrl.']]>','ProxyDetector');
                header('Location: ' . $this->redirectUrl);
            } else {
                //Track only when user see 403 error
                if(!$this->proxyDetectorRewrite) {
                    Yii::error('Show forbidden 403','ProxyDetector');
                }
                header('HTTP/1.0 403 Forbidden');
                echo '<html>
                    <head><title>403 Forbidden</title></head>
                    <body bgcolor="white">
                    <center><h1>403 Forbidden</h1></center>
                    <hr><center>nginx/1.8.0</center>
                    </body>
                </html>';
            }
            exit;
        }
    }

    /**
     * Check if white ip
     * @param $ip
     * @return bool
     */
    private function is_white_ip($ip) {

        if(empty(Yii::$app->params['geoFilter']['allowFromIp'])) {
            return true;
        }

        return in_array($ip, Yii::$app->params['geoFilter']['allowFromIp']);
    }

    /**
     * Got to redirector if user come from no redirector :)
     * @return bool
     */
    private function is_need_redirect() {

        if($this->proxyDetectorRewrite) {
            return false;
        }

        //Set redirector config
        $rc = Yii::$app->params['redirector'];

        $referer = Yii::$app->request->getReferrer();

        $aRedirector = parse_url($rc['url']);

        if(!empty($referer) && strpos($referer, $aRedirector['host']) !== false) {
            return false;
        }

        $query = '/';
        if(Yii::$app->request->getQueryString()) {
            $query .= '?' . Yii::$app->request->getQueryString();
        }

        $this->redirectUrl = $rc['url'] . ($rc['encode'] ? urlencode($query) : $query);

        return true;
    }

    /**
     * Check is it proxy request?
     *
     * @param $url
     * @return bool
     */
    private function is_proxy_request($url)
    {
        //Disable proxy detector for conditions
        if( empty($url) || empty($_SERVER['HTTP_HOST']) || !in_array($_SERVER['HTTP_HOST'], $this->domains) ) {
            return false;
        }

        //Формирование данных для проверки
        $ip = Yii::$app->request->getUserIP();
        $data = [
            'remote_addr' => $ip,
            'headers' => getallheaders(),
        ];

        //Generate hash
        $_hash = md5(Yii::$app->request->headers->get('User-Agent') . '-' . $ip);

        //Check store
        $_store = Yii::$app->session->get('DetectProxyStore');

        if (isset($_store[$_hash]) && $_store[$_hash]['expired'] > time()) {
            return $_store[$_hash]['value'];
        }

        $ch = curl_init();

        // установка URL и других необходимых параметров
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->proxyTimeout);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        //Set special headers
        if(!empty($this->headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        }

        $response = curl_exec($ch);

        //Try to get error number
        if(curl_errno($ch))
            Yii::error('Proxy detect error: <![CDATA['.curl_error($ch).']]>','proxy_detect');

        curl_close($ch);

        if($response !== 'false')
            Yii::error('Proxy detect error: <![CDATA['.$response.'; '.http_build_query($data).']]>','proxy_detect');

        //Store proxy detect data
        $_store[$_hash]['value'] = ($response !== 'false');
        $_store[$_hash]['expired'] = time() + 3600; //set for 1 hour
        Yii::$app->session->set('DetectProxyStore', $_store);

        return $_store[$_hash]['value'];
    }
}