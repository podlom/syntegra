<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Error Log';
$this->params['breadcrumbs'][] = ['label' => 'All errors', 'url' => ['/error-log']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div align="center">
        <img src="<?=Url::to('@web/error-log/graph?width=800&height=100&hash_id=' . $hash_id . '&period=last_day&label=Last+day', true)?>" width="862" height="202">
        </br>
        </br>
        <img src="<?=Url::to('@web/error-log/graph?width=800&height=100&hash_id=' . $hash_id . '&period=last_week&label=Last+week', true)?>" width="862" height="202">
        </br>
        </br>
        <img src="<?=Url::to('@web/error-log/graph?width=800&height=100&hash_id=' . $hash_id . '&period=last_month&label=Last+month', true)?>" width="862" height="202">
        </br>
        </br>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'afterRow' => function($model, $key, $index) {
            static $errorCounter, $backtraceCounter, $platformTitles;

            if( !isset($backtraceCounter) )
                $backtraceCounter = 0;

            if( !isset($platformTitles) ) {
                $platformTitles = \common\components\DetectPlatform::platformTitles();
            }

            if(!empty($model['backtrace'])) {
                $back = unserialize($model['backtrace']);
                if (!$back) {
                    $back = array();
                }

                if ($backtraceCounter < 100) {
                    $model['str_backtrace'] = '';

                    if (is_array($back) && count($back) > 0) {
                        $prettyBacktrace = array();

                        $amountOfBacktraces = count($back);
                        foreach ($back as $index => $item) {
                            $offset = $amountOfBacktraces - $index;
                            $prettyBacktrace[] = Yii::$app->log->targets['db']->getTraceAsString($offset, $item);
                        }

                        $model['str_backtrace'] = join("<br>\n", $prettyBacktrace);
                        $back = array();
                    }

                    $backtraceCounter++;
                } else {
                    $model['str_backtrace'] = "See this backtrace in database.";
                }
            }

            $errorCounter = !isset($errorCounter)?1:$errorCounter+1;

            $content = '<b>Uname:</b> ' . $model['uname'] . ' <br>
                        <b>Category:</b> ' .$model['category']. '<br>
                        <b>Host:</b> ' .$model['host']. '<br>
                        <b>Request URI:</b> ' .$model['request_uri']. '<br>
                        <b>Remote IP:</b> ' .$model['remote_host']. ' (' .($model['remote_ip']==0?'console':long2ip($model['remote_ip'])). ')<br>
                        <b>HTTP Referer:</b> ' .$model['http_referer']. '<br>
                        <b>User Agent:</b> ' .$model['user_agent']. '<br>
                        <b>User Id:</b> ' .$model['user_id']. '<br>
                        <b>Platform:</b> ' .($model['platform'] == 0?'console':$platformTitles[$model['platform']]). '<br>
                        <b>Backtrace:</b><br>' . $model['str_backtrace'];

            return Html::tag('tr', Html::tag('td', $content, ['colspan' => 7]), ['id' => 'detailed-error-hash-' . $key,'style'=>'display: none;']);
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Time',
                'content' => function($error) {
                    return strftime('%c',$error['time']);
                }
            ],
            [
                'label' => 'Message',
                'content' => function($error) {
                    $error['error_message'] = htmlspecialchars($error['error_message']);
                    return '<span title="' . $error['error_message'] . '">' . Yii::$app->log->targets['db']->cutMessage($error['error_message'], 350) . '</span>';
                }
            ],
            'repeated',
            [
                'label' => 'Uname',
                'content' => function($error) {
                    return '<span title="' . $error['uname'] . '">' . Yii::$app->log->targets['db']->cutMessage($error['uname'], 15) . '</span>';
                }
            ],
            [
                'label' => 'Place',
                'content' => function($error) {
                    return '<span title="' . $error['error_file'] . '">' . Yii::$app->log->targets['db']->getShortPath($error['error_file']) . '</span>';
                }
            ],
            [
                'label' => 'Details',
                'content' => function($error, $key) {
                    return Html::a(
                        'More',
                        'javascript:void(0)',
                        ['onclick' => '
                            var el = document.getElementById("detailed-error-hash-'.$key.'");
                            var val = el.style.display;
                            el.style.display = (val == "none" ? "": "none");'
                        ]
                    );
                }
            ],
        ],
    ]);
    ?>

</div>
