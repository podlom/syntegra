<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\GroupQuestions */

$this->title = 'Update Group Questions: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Group Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="group-questions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
