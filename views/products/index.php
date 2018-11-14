<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\productsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

 <p>
        <?= Html::a('создать новый', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nomi',
            'turi',
            /*'rasmi',*/
            'tavfsiloti',
            'narxi',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
