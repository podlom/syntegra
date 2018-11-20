<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SeometricsForm */
/* @var $seometrics common\models\Seometrics */

$this->title = 'Редактирование метрики: ' . ' ' . $seometrics->slug;
$this->params['breadcrumbs'][] = ['label' => 'Seo метрики', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $seometrics->slug, 'url' => ['view', 'id' => $seometrics->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="seometrics-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
