<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Meta */

$this->title = 'Метаданные: ' . $model->url;
$this->params['breadcrumbs'][] = ['label' => 'Метаданные', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->url;
?>
<div class="meta-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php
        echo Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить эти метаданные?',
                'method' => 'post',
            ],
        ]);
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id:raw',
            'url:text',
            'published:boolean',
            'title',
            'og_title',
            'description:text',
            'og_description:text',
            'keywords:text',
            'og_image',
            'meta_image',
            'h1:text',
            'seo:text',
            'lang',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
