<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\VideoConsultantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Video Consultants');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-consultant-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Video Consultant'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            'id',
            'category_id',
            'lang',
            'title',
            // 'img_url:url',
            // 'video_url:url',
            'short_descr',
            'published:boolean',
            'sort',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
