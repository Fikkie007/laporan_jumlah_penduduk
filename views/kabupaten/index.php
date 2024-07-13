<?php

/** @var yii\web\View $this */

use app\models\Provinces;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$provOpts = Provinces::options('province_id', 'name');

?>

<div class="d-flex justify-content-between mb-3">
    <div>
        <?= Html::a(
            '<i class="bi bi-plus me-1"></i> Tambah Data',
            ['form'],
            [
                'data-pjax' => 0,
                'class' => 'btn btn-success',
            ]
        ) ?>
    </div>

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'form-inline']
    ]); ?>

    <div class="d-flex col gap-2">
        <?= Html::dropDownList('prov', $searchModel->prov ?? null, $provOpts, [
            'class' => 'form-select',
            'prompt' => 'Semua Provinsi',
            'onchange' => "$(this).trigger('submit')"
        ]) ?>

        <?= Html::input('search', 'search', $searchModel->search, [
            'class' => 'mr-sm-2 form-control',
            'placeholder' => 'Pencarian ...',
        ]) ?>

    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php \yii\widgets\Pjax::begin(['options' => ['class' => 'card card-sticky']]) ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => jeemce\grid\SerialColumn::class
        ],
        'name',
        'province.name',
        [
            'class' => \jeemce\grid\ActionColumn::class,
        ],
    ],
    'pager' => [
        'class' => yii\bootstrap5\LinkPager::class,
        'options' => ['class' => 'pagination justify-content-center'],
    ],
]) ?>

<div class="col-md-auto">
    <?= \jeemce\helpers\WidgetHelper::providerSummary($dataProvider) ?>
</div>

<?php \yii\widgets\Pjax::end() ?>