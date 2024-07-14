<?php

use app\models\Kabupaten;
use jeemce\helpers\ArrayHelper;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;

/**
 * @var Provinsi[] $models
 */

$spreadsheet = new Spreadsheet;
$worksheet = $spreadsheet->getActiveSheet();

$fields = [
    'name',
    'province.name',
    'totalPenduduk',
];

$model = $models[0] ?? new Kabupaten();
$headers = [];
foreach ($fields as $field) {
    $headers[] = $model->getAttributeLabel($field);
}

$xmin = 'A';
$ymin = 1;
$y = $ymin;

$x = $xmin;
foreach ($headers as $header) {
    $worksheet->getCell("{$x}{$y}")->setValue($header);
    $x++;
}
$y++;

foreach ($models as $model) {
    $x = $xmin;
    foreach ($fields as $field) {
        $worksheet->getCell("{$x}{$y}")->setValue(ArrayHelper::getValue($model, $field));
        $x++;
    }
    $y++;
}

$download = "laporan-kabupaten-kota.xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $download . '"');

$writer = new WriterXlsx($spreadsheet);
$writer->save('php://output');
exit;

// dd($writer);
// exit;
