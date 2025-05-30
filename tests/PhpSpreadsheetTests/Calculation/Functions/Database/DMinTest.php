<?php

declare(strict_types=1);

namespace PhpOffice\PhpSpreadsheetTests\Calculation\Functions\Database;

use PhpOffice\PhpSpreadsheet\Calculation\Database\DMin;
use PhpOffice\PhpSpreadsheet\Calculation\Information\ExcelError;
use PHPUnit\Framework\Attributes\DataProvider;

class DMinTest extends SetupTeardownDatabases
{
    /**
     * @param mixed[] $database
     * @param mixed[][] $criteria
     */
    #[DataProvider('providerDMin')]
    public function testDirectCallToDMin(int|float|string $expectedResult, array $database, string|null|int $field, array $criteria): void
    {
        $result = DMin::evaluate($database, $field, $criteria);
        self::assertEqualsWithDelta($expectedResult, $result, 1.0e-12);
    }

    /**
     * @param mixed[] $database
     * @param mixed[][] $criteria
     */
    #[DataProvider('providerDMin')]
    public function testDMinAsWorksheetFormula(int|float|string $expectedResult, array $database, string|null|int $field, array $criteria): void
    {
        $this->prepareWorksheetWithFormula('DMIN', $database, $field, $criteria);

        $result = $this->getSheet()->getCell(self::RESULT_CELL)->getCalculatedValue();
        self::assertEqualsWithDelta($expectedResult, $result, 1.0e-12);
    }

    public static function providerDMin(): array
    {
        return [
            [
                75,
                self::database1(),
                'Profit',
                [
                    ['Tree', 'Height', 'Height'],
                    ['=Apple', '>10', '<16'],
                    ['=Pear', '>12', null],
                ],
            ],
            [
                0.48,
                self::database3(),
                'Score',
                [
                    ['Subject', 'Age'],
                    ['Science', '>8'],
                ],
            ],
            [
                0.55,
                self::database3(),
                'Score',
                [
                    ['Subject', 'Gender'],
                    ['Math', 'Male'],
                ],
            ],
            'omitted field name' => [
                ExcelError::VALUE(),
                self::database1(),
                null,
                self::database1(),
            ],
            'field column number okay' => [
                8,
                self::database1(),
                2,
                self::database1(),
            ],
            /* Excel seems to return #NAME? when column number
               is too high or too low. This makes so little sense
               to me that I'm not going to bother coding that up,
               content to return #VALUE! as an invalid name would */
            'field column number too high' => [
                ExcelError::VALUE(),
                self::database1(),
                99,
                self::database1(),
            ],
            'field column number too low' => [
                ExcelError::VALUE(),
                self::database1(),
                0,
                self::database1(),
            ],
        ];
    }
}
