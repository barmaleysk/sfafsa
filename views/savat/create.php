<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\savat */


$this->params['breadcrumbs'][] = ['label' => 'Savats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="savat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
