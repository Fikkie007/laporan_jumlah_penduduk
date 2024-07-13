<div class="card-footer row align-items-center">
    <div class="col-md">
        <?= yii\bootstrap5\LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
    </div>
    <div class="col-md-auto">
        <?= \jeemce\helpers\WidgetHelper::providerSummary($dataProvider) ?>
    </div>
</div>