<?php

declare(strict_types=1);

namespace PhpOffice\PhpSpreadsheetTests\Calculation\Functions\Information;

use PhpOffice\PhpSpreadsheet\Calculation\Calculation;
use PhpOffice\PhpSpreadsheet\Calculation\Information\ExcelError;
use PHPUnit\Framework\TestCase;

class ErrorTypeTest extends TestCase
{
    public function testErrorTypeNoArgument(): void
    {
        $result = ExcelError::type();
        self::assertSame(ExcelError::NA(), $result);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('providerErrorType')]
    public function testErrorType(int|string $expectedResult, mixed $value): void
    {
        $result = ExcelError::type($value);
        self::assertSame($expectedResult, $result);
    }

    public static function providerErrorType(): array
    {
        return require 'tests/data/Calculation/Information/ERROR_TYPE.php';
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('providerErrorTypeArray')]
    public function testErrorTypeArray(array $expectedResult, string $values): void
    {
        $calculation = Calculation::getInstance();

        $formula = "=ERROR.TYPE({$values})";
        $result = $calculation->_calculateFormulaValue($formula);
        self::assertEquals($expectedResult, $result);
    }

    public static function providerErrorTypeArray(): array
    {
        return [
            'vector' => [
                [[2, 4, 7, ExcelError::NA(), ExcelError::NA(), ExcelError::NA(), 5]],
                '{5/0, "#REF!", "#N/A", 1.2, TRUE, "PHP", "#NAME?"}',
            ],
        ];
    }
}
