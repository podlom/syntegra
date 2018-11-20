<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AdminGroup */

$this->title = Yii::t('app', 'Create Admin Group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
