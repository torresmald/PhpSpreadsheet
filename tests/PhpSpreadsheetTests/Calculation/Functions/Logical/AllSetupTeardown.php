<?php

declare(strict_types=1);

namespace PhpOffice\PhpSpreadsheetTests\Calculation\Functions\Logical;

use PhpOffice\PhpSpreadsheet\Calculation\Calculation;
use PhpOffice\PhpSpreadsheet\Calculation\Exception as CalcException;
use PhpOffice\PhpSpreadsheet\Calculation\Functions;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PHPUnit\Framework\TestCase;

class AllSetupTeardown extends TestCase
{
    private string $compatibilityMode;

    private ?Spreadsheet $spreadsheet = null;

    private ?Worksheet $sheet = null;

    protected function setUp(): void
    {
        $this->compatibilityMode = Functions::getCompatibilityMode();
    }

    protected function tearDown(): void
    {
        Functions::setCompatibilityMode($this->compatibilityMode);
        $this->sheet = null;
        if ($this->spreadsheet !== null) {
            $this->spreadsheet->disconnectWorksheets();
            $this->spreadsheet = null;
        }
    }

    protected static function setOpenOffice(): void
    {
        Functions::setCompatibilityMode(Functions::COMPATIBILITY_OPENOFFICE);
    }

    protected static function setGnumeric(): void
    {
        Functions::setCompatibilityMode(Functions::COMPATIBILITY_GNUMERIC);
    }

    protected function mightHaveException(mixed $expectedResult): void
    {
        if ($expectedResult === 'exception') {
            $this->expectException(CalcException::class);
        }
    }

    protected function setCell(string $cell, mixed $value): void
    {
        if ($value !== null) {
            if (is_string($value) && is_numeric($value)) {
                $this->getSheet()->getCell($cell)->setValueExplicit($value, DataType::TYPE_STRING);
            } else {
                $this->getSheet()->getCell($cell)->setValue($value);
            }
        }
    }

    protected function getSpreadsheet(): Spreadsheet
    {
        if ($this->spreadsheet !== null) {
            return $this->spreadsheet;
        }
        $this->spreadsheet = new Spreadsheet();

        return $this->spreadsheet;
    }

    protected function getSheet(): Worksheet
    {
        if ($this->sheet !== null) {
            return $this->sheet;
        }
        $this->sheet = $this->getSpreadsheet()->getActiveSheet();

        return $this->sheet;
    }

    protected function runTestCase(string $functionName, mixed $expectedResult, mixed ...$args): void
    {
        $this->mightHaveException($expectedResult);
        $sheet = $this->getSheet();
        $formula = "=$functionName(";
        $comma = '';
        $row = 0;
        foreach ($args as $arg) {
            ++$row;
            $cellId = "A$row";
            $formula .= "$comma$cellId";
            $comma = ',';
            $this->setCell($cellId, $arg);
        }
        $formula .= ')';
        $this->setCell('B1', $formula);
        self::assertSame($expectedResult, $sheet->getCell('B1')->getCalculatedValue());
    }

    protected function setArrayAsValue(): void
    {
        $spreadsheet = $this->getSpreadsheet();
        $calculation = Calculation::getInstance($spreadsheet);
        $calculation->setInstanceArrayReturnType(
            Calculation::RETURN_ARRAY_AS_VALUE
        );
    }
}
