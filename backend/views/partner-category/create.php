<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PartnerCategory */

$this->title = Yii::t('app', 'Create Partner category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Partner category'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
