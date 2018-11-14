<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Category;
use app\controllers\UploadedFile;
/* @var $this yii\web\View */
/* @var $model app\models\products */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nomi')->textInput(['maxlength' => true]) ?>

    
    <?= $form->field($model, 'turi')->dropDownList(ArrayHelper::map(Category::find()->asArray()->all(),'nomi','nomi'),['prompt'=>'Главный категория']) ?>



    <?= $form->field($model, 'tavfsiloti')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'narxi')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'rasmi')->fileInput()  ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
