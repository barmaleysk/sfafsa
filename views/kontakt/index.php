<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KontaktSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kontakts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kontakt-index">


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
            'manzili',
            'telefoni',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
