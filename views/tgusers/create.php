<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\tgusers */


$this->params['breadcrumbs'][] = ['label' => 'Tgusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tgusers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
