<?php

use app\models\Penduduk;
use app\models\Provinces;
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
    'kabupaten.name',
    'detailAlamat',
    'jenisKelaminLabel',
    'created_at'
];

$model = $models[0] ?? new Penduduk();
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

$download = "penduduk.xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $download . '"');

$writer = new WriterXlsx($spreadsheet);
$writer->save('php://output');
exit;

// dd($writer);
// exit;
