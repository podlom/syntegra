<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\PartnerTechnology;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PartnerTechnologySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Partner Technologies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-technology-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Partner Technology', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute'=>'partner_id',
                'label'=>'Partner',
                'content'=>function($data){
                    return PartnerTechnology::getPartnerName($data->partner_id)->title;
                },
                'filter' => PartnerTechnology::getPartners()
            ],
            [
                'attribute'=>'technology_id',
                'label'=>'Partner',
                'content'=>function($data){
                    return PartnerTechnology::getTechnologyName($data->technology_id)->title;
                },
               'filter' => PartnerTechnology::getTechnologies()
            ],
            'lang',
            'sort',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
