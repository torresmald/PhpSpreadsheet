<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;

require __DIR__ . '/../Header.php';
/** @var PhpOffice\PhpSpreadsheet\Helper\Sample $helper */
$category = 'Date/Time';
$functionName = 'NOW';
$description = 'Returns the serial number of the current date and time';

$helper->titles($category, $functionName, $description);

// Create new PhpSpreadsheet object
$spreadsheet = new Spreadsheet();
$worksheet = $spreadsheet->getActiveSheet();

$worksheet->setCellValue('A1', '=NOW()');
$worksheet->getStyle('A1')
    ->getNumberFormat()
    ->setFormatCode('yyyy-mm-dd hh:mm:ss');

// Test the formulae
$helper->log(
    'Today is '
    . $worksheet->getCell('A1')->getCalculatedValueString()
    . ' ('
    . $worksheet->getCell('A1')->getFormattedValue()
    . ')'
);
