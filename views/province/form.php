<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

?>

<?php $form = ActiveForm::begin([
    'id' => 'form-elem',
]);
?>

<?= $form->field($model, 'name')->textInput() ?>

<?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>