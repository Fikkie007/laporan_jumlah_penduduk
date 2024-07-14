<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<div class="d-flex justify-content-between mb-3">
    <div>
        <?= Html::a(
            '<i class="bi bi-plus me-1"></i> Export',
            ['export'],
            [
                'data-pjax' => 0,
                'class' => 'btn btn-success',
            ]
        ) ?>
    </div>


    <div>
        <?php $form = ActiveForm::begin([
            'action' => Url::current(['laporan']),
            'method' => 'get',
            'options' => ['class' => 'form-inline']
        ]); ?>

        <?= Html::input('search', 'search', $searchModel->search, [
            'class' => 'mr-sm-2 form-control',
            'placeholder' => 'Pencarian ...',
        ]) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php \yii\widgets\Pjax::begin(['options' => ['class' => 'card card-sticky']]) ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => jeemce\grid\SerialColumn::class
        ],
        'name',
        'totalPenduduk'
    ],
    'pager' => [
        'class' => yii\bootstrap5\LinkPager::class,
        'options' => ['class' => 'pagination justify-content-center'],
    ],
]) ?>

<?php \yii\widgets\Pjax::end() ?>