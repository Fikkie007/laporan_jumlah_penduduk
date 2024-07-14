<?php

use app\models\Kabupaten;
use app\models\Provinces;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$provOpts = Provinces::options('province_id', 'name');
$kabOpts = Kabupaten::options('kabupaten_id', 'name');

$ajaxUrl = Url::to(['/penduduk/options']);
?>

<?php
$this->registerJs("
    function fetchKabupatenOptions(provinceId) {
        $.get('{$ajaxUrl}', { province_id: provinceId })
            .done(function(data) {
                $('#kabupaten-id').html(data);
            });
    }

    $(document).ready(function() {
        var currentProvinceId = $('#province-id').val();
        fetchKabupatenOptions(currentProvinceId);
    });

    $('#province-id').change(function(){
        var provinceId = $(this).val();
        fetchKabupatenOptions(provinceId);
    });
");
?>

<?php $form = ActiveForm::begin([
    'id' => 'form-elem',
]);
?>

<?= $form->field($model, 'name')->textInput() ?>

<?= $form->field($model, 'jenis_kelamin')->dropDownList(['1' => 'Laki-laki', '0' => 'Perempuan'], ['prompt' => 'Pilih Jenis Kelamin']) ?>

<?= $form->field($model, 'tanggal_lahir')->textInput(['type' => 'date']) ?>

<?= $form->field($model, 'nik')->textInput(['type' => 'number']) ?>

<?= $form->field($model, 'alamat')->textarea(['rows' => 4]) ?>

<?php if (empty($model->id)) { ?>
    <?= $form->field($model, 'created_at')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false) ?>
<?php } else { ?>
    <?= $form->field($model, 'updated_at')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false) ?>
<?php } ?>

<?= $form->field($model, 'province_id')->dropDownList($provOpts, [
    'prompt' => 'Pilih Provinsi',
    'id' => 'province-id',
]) ?>

<?= $form->field($model, 'kabupaten_id')->dropDownList([], [
    'prompt' => 'Pilih Kabupaten / Kota',
    'id' => 'kabupaten-id',
]) ?>

<?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>