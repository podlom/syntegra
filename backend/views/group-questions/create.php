<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\GroupQuestions */

$this->title = 'Create Group Questions';
$this->params['breadcrumbs'][] = ['label' => 'Group Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-questions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
