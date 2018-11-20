<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MetaForm */
/* @var $meta common\models\Meta */

$this->title = 'Редактирование метаданных: ' . $meta->url;
$this->params['breadcrumbs'][] = ['label' => 'Метаданные', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $meta->url, 'url' => ['view', 'id' => $meta->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="meta-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
