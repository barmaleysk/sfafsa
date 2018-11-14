<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\tgusersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tgusers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tgusers-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'firstname',
            'username',
            'kirganvaqti',
            'datareg',
            'telefon',
            //'tili',
            //'step',
            //'asos',

        ],
    ]); ?>
</div>
