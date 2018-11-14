<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Category;
/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

  
  <?= $form->field($model, 'nomi')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'parent')->dropDownList(ArrayHelper::map(Category::find()->asArray()->all(),'nomi','nomi'),['prompt'=>'Главный категория']) ?>

  



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
