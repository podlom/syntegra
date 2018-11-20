<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\web\User;

class GeoFilter extends Component
{
    private $params = [];

    public function init()
    {
        $this->params = Yii::$app->params['geoFilter'];

        $ip = Yii::$app->request->getUserIP();

        if (!in_array($ip, $this->params['allowFromIp'])) {
            $this->checkAccess($ip);
        }

        if(Yii::$app->user instanceof User && !Yii::$app->user->getIsGuest() && Yii::$app->user->identity->blocked) {
            Yii::$app->user->logout(true);
        }
    }

    public function checkAccess($ip)
    {
        $country_code = geoip_country_code_by_name($ip);
        if (empty($country_code)) {
            $this->denyAccess();
        }

        $forbidden_countries = $this->params['forbiddenCountries'];
        if (array_key_exists($country_code, $forbidden_countries)) {
            $request_path = sprintf('/%s', Yii::$app->request->getPathInfo());
            $urls = $forbidden_countries[$country_code];
            if (is_scalar($urls)) {
                $urls = [$urls];
            }
            foreach ($urls as $url) {
                if (substr($request_path, 0, strlen($url)) === $url) {
                    $this->denyAccess();
                }
            }
        }
    }

    public function isMultiAccount() {
        $ip = Yii::$app->request->getUserIP();
        $return = false;
        if (!in_array($ip, $this->params['allowFromIp'])) {
            $return = $this->multiAccountBan($ip);
        }
        return $return;
    }

    public function getMultiAccountMessage() {
        return 'Достигнут лимит регистраций с Вашего ip. Дальнейшая регистрация аккаунтов недоступна.';
    }

    private function multiAccountBan($ip) {

        $ua = Yii::$app->request->getUserAgent();

        $cacheKey = 'multi_account_'.md5($ip.$ua);
        if(!Yii::$app->cache->exists($cacheKey))
        {
            $stm = Yii::$app->db->createCommand('
                SELECT
                    count(u.id) as cnt
                FROM
                    users u
                LEFT JOIN
                    user_logins ul ON u.id=ul.user_id AND ul.date BETWEEN u.created - INTERVAL 1 MINUTE AND u.created + INTERVAL 1 MINUTE
                LEFT JOIN
                    payments as p ON p.user_id=u.id AND p.status=3 AND p.operation_id=1
                WHERE
                    u.ip = INET_ATON(:ip) AND ul.browser = :uagent AND p.id IS NULL
            ');

            $stm->bindValue('ip', $ip);
            $stm->bindValue('uagent', $ua);
            $stm->execute();

            $res = $stm->queryOne();

            if(!empty($res['cnt']) && $res['cnt'] > 3) {
                Yii::error('IP in ban NEW LOGIC <![CDATA[Ip: '.$ip.'; Ua: '.$ua.'; Res: '.$res['cnt'].']]>','BanFilter');
                Yii::$app->cache->set($cacheKey, $res, 60 * 60 * 4);
            } else {
                Yii::$app->cache->set($cacheKey, $res, 30);
            }

        } else {
            $res = Yii::$app->cache->get($cacheKey);
        }

        if(!empty($res['cnt']) && $res['cnt'] > 3) {
            return true;
        } else {
            return false;
        }
    }

    private function denyAccess()
    {
        $ip = Yii::$app->request->getUserIP();
        header('HTTP/1.0 403 Forbidden');
        Yii::error('Deny access <![CDATA['.print_r(geoip_country_code_by_name($ip),1).']]>','GeoFilter');
        echo $this->params['denyMessage'];
        exit;
    }
}
