<?php
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'file')->fileInput()->label('Картинка') ?>
<?= $form->field($model, 'text')->textArea()->label('Текст') ?>

<button>Отправить</button>

<?php ActiveForm::end() ?>