<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MetaForm */

$this->title = 'Добавление метаданных';
$this->params['breadcrumbs'][] = ['label' => 'Метаданные', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meta-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
