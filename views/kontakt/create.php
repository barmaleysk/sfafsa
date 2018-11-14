<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\kontakt */

$this->params['breadcrumbs'][] = ['label' => 'Kontakts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kontakt-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
