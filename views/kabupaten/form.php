<?php

use app\models\Provinces;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$provOpts = Provinces::options('province_id', 'name');
?>

<?php $form = ActiveForm::begin([
    'id' => 'form-elem',
]);
?>

<?= $form->field($model, 'name')->textInput() ?>

<?= $form->field($model, 'province_id')->dropDownList($provOpts, [
    'prompt' => 'Pilih Provinsi'
])
?>

<?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>