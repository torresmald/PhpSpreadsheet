<?php

require __DIR__ . '/../Header.php';
/** @var PhpOffice\PhpSpreadsheet\Spreadsheet */
$spreadsheet = require __DIR__ . '/../templates/sampleSpreadsheet.php';
$spreadsheet->getProperties()->setTitle('Non-embedded images');

/** @var PhpOffice\PhpSpreadsheet\Helper\Sample $helper */
$helper->write($spreadsheet, __FILE__, ['Html']);
