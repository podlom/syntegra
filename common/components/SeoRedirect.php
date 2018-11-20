<?php

namespace common\components;

use Yii;
use yii\base\Component;

class SeoRedirect extends Component
{
    public function init()
    {
        parent::init();
        static::makeRedirects();
    }

    public static function makeRedirects()
    {
        if (!defined('PROJECT_SUFFIX'))
            return;

        if (PROJECT_SUFFIX == 'vr') {
            $seoRedirectRules = [
                '/game/play-free/(.*)' => '/game/view/demo/{game_uri}',
                '/page/terms' => '/terms',
                '/page/about' => '/about',
                '/game/all' => '/game/hall',
                '/promotion' => '/user/bonus/',
                '/lottery' => '/lotteries',
                '/rating' => '/game/fame',
                '/game/publisher/novomatic' => '/game/developer/novomatic',
                '/game/publisher/igrosoft' => '/game/developer/igrosoft',
                '/game/publisher/netent' => '/game/developer/net-entertainment',
                '/game/publisher/other' => '/game/other',
            ];

            foreach ($seoRedirectRules as $redirectFrom => $redirectTo) {
                if (preg_match('|' . $redirectFrom . '|', Yii::$app->request->getUrl(), $m1)) {
                    $redirectTo = str_replace('{game_uri}', $m1[1], $redirectTo);
                    //Yii::error('Redirecting from: <![CDATA[' . $redirectFrom . ' to: ' . $redirectTo . ']]>', __METHOD__);
                    Yii::$app->response->redirect('@web' . $redirectTo, 301)->send();
                    Yii::$app->end();
                }
            }
        }
    }
}