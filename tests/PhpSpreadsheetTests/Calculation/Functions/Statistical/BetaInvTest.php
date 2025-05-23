<?php

declare(strict_types=1);

namespace PhpOffice\PhpSpreadsheetTests\Calculation\Functions\Statistical;

use PhpOffice\PhpSpreadsheet\Calculation\Calculation;

class BetaInvTest extends AllSetupTeardown
{
    #[\PHPUnit\Framework\Attributes\DataProvider('providerBETAINV')]
    public function testBETAINV(mixed $expectedResult, mixed ...$args): void
    {
        $this->runTestCaseReference('BETAINV', $expectedResult, ...$args);
    }

    public static function providerBETAINV(): array
    {
        return require 'tests/data/Calculation/Statistical/BETAINV.php';
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('providerBetaInvArray')]
    public function testBetaInvArray(array $expectedResult, string $argument1, string $argument2, string $argument3): void
    {
        $calculation = Calculation::getInstance();

        $formula = "=BETAINV({$argument1}, {$argument2}, {$argument3})";
        $result = $calculation->_calculateFormulaValue($formula);
        self::assertEqualsWithDelta($expectedResult, $result, 1.0e-14);
    }

    public static function providerBetaInvArray(): array
    {
        return [
            'row/column vectors' => [
                [[0.24709953547, 0.346789605377], [0.215382947588, 0.307844847105]],
                '0.25',
                '{5, 7.5}',
                '{10; 12}',
            ],
        ];
    }
}
