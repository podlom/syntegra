<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\VideoConsultant */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Video Consultants'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-consultant-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category_id',
            'lang',
            'title',
            'img_url:url',
            'video_url:url',
            'short_descr',
            'published',
            'sort',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
