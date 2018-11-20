<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Technologies */

$this->title = 'Create Technologies';
$this->params['breadcrumbs'][] = ['label' => 'Technologies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="technologies-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
