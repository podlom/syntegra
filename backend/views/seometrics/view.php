<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Seometrics */

$this->title = $model->slug;
$this->params['breadcrumbs'][] = ['label' => 'Seo метрики', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php
        echo Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить Seo метрику?',
                'method' => 'post',
            ],
        ]);
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id:raw',
            'slug:text',
            'host:text',
            'published:boolean',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
