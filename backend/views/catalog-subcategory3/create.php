<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CatalogSubcategory3 */

$this->title = Yii::t('app', 'Create Catalog Subcategory3');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Catalog Subcategory3s'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-subcategory3-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
