<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\savatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Savats';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="savat-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

 

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nomi',
            'narxi',
            'dona',
            
            //'turi',
            'telefon',
            //'manzil',
            'ism',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
