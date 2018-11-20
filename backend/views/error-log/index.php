<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Error Log';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Graph',
                'content' => function($error) {
                    return '<img src="' .
                    Url::to('@web/error-log/graph?width=60&height=25&margin=0,0,0,0&no_labels=1&hash_id=' . $error['error_hash_id'], true) .
                    '" width="62" height="27" border="0">';
                }
            ],
            [
                'label' => 'Message',
                'content' => function($error) {
                    if($error['error_message'] == '') {
                        $error['error_message'] = 'UNKNOWN';
                    }

                    $error['error_message'] = htmlspecialchars($error['error_message']);

                    return Html::a(
                        //Cut error message
                        Yii::$app->log->targets['db']->cutMessage($error['error_message'], 350),

                        Url::to('@web/error-log/detailed?hash_id=' . $error['error_hash_id'], true),
                        ['title' => $error['error_message']]
                    );
                }
            ],
            'category',
            'repeated',
            [
                'label' => 'Place',
                'content' => function($error) {
                    return '<span title="' . $error['error_file'] . '">' . Yii::$app->log->targets['db']->getShortPath($error['error_file']) . '</span>';
                }
            ],
            [
                'label' => 'Last time',
                'content' => function($error) {
                    return Yii::$app->log->targets['db']->getTimeInterval(time(), $error['last_time']);
                }
            ],
            [
                'label' => 'First time',
                'content' => function($error) {
                    return Yii::$app->log->targets['db']->getTimeInterval(time(), $error['first_time']);
                }
            ],
        ],
    ]); ?>

</div>
