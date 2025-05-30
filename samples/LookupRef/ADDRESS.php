<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;

require __DIR__ . '/../Header.php';
/** @var PhpOffice\PhpSpreadsheet\Helper\Sample $helper */
$helper->log('Returns a text reference to a single cell in a worksheet.');

// Create new PhpSpreadsheet object
$spreadsheet = new Spreadsheet();
$worksheet = $spreadsheet->getActiveSheet();

$worksheet->getCell('A1')->setValue('=ADDRESS(2,3)');
$worksheet->getCell('A2')->setValue('=ADDRESS(2,3,2)');
$worksheet->getCell('A3')->setValue('=ADDRESS(2,3,2,FALSE)');
$worksheet->getCell('A4')->setValue('=ADDRESS(2,3,1,FALSE,"[Book1.xlsx]Sheet1")');
$worksheet->getCell('A5')->setValue('=ADDRESS(2,3,1,FALSE,"EXCEL SHEET")');

for ($row = 1; $row <= 5; ++$row) {
    $cell = $worksheet->getCell("A{$row}");
    $helper->log("A{$row}: " . $cell->getValueString() . ' => ' . $cell->getCalculatedValueString());
}
