<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\savat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="savat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nomi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'narxi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dona')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'turi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'manzil')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ism')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
