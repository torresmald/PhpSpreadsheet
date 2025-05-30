<?php

declare(strict_types=1);

namespace PhpOffice\PhpSpreadsheetTests\Calculation\Functions\Financial;

use PHPUnit\Framework\Attributes\DataProvider;

class PmtTest extends AllSetupTeardown
{
    /** @param mixed[] $args */
    #[DataProvider('providerPMT')]
    public function testPMT(mixed $expectedResult, array $args): void
    {
        $this->runTestCase('PMT', $expectedResult, $args);
    }

    public static function providerPMT(): array
    {
        return require 'tests/data/Calculation/Financial/PMT.php';
    }
}
