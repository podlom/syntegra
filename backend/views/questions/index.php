<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\QuestionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Questions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-group-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Question'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            //'json_data',
            /*[
                'label' => 'JSON form',
                    'value' => 'json_data'

            ],*/
            [
                'label' => 'Statistic',
               'content'=>function($data){
                    return "<a href='".\yii\helpers\Url::to('/statistic/'.$data->id)."'>Watch statistic</a>";
               }

            ],
            [
              'attribute'=>'title',
               'content'=>function($data) {
                   if (strlen($data->title) < 90) {
                       return substr($data->title, 0, 90);
                   } else {
                       return substr($data->title, 0, 90) . " ...";
                   }
               }
            ],
            'id_group',

            ['class' => 'yii\grid\ActionColumn'],

        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
