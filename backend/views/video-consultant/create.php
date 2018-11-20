<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\VideoConsultant */

$this->title = Yii::t('app', 'Create Video Consultant');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Video Consultants'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-consultant-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
