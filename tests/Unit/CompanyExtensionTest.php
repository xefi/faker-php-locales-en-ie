<?php

namespace Xefi\Faker\EnIe\Tests\Unit;

use Random\Randomizer;
use ReflectionClass;
use Xefi\Faker\EnIe\Extensions\CompanyExtension;

final class CompanyExtensionTest extends TestCase
{
    protected array $companies = [];

    protected function setUp(): void
    {
        parent::setUp();

        $companyExtension = new CompanyExtension(new Randomizer());
        $this->companies = (new ReflectionClass($companyExtension))->getProperty('companies')->getValue($companyExtension);
    }

    public function testCompany(): void
    {
        $results = [];
        for ($i = 0; $i < count($this->companies); $i++) {
            $results[] = $this->faker->unique()->company();
        }

        $this->assertEqualsCanonicalizing(
            $this->companies,
            $results
        );
    }

    public function testCompanyNumber(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $this->assertMatchesRegularExpression('/^[1-7]\d{5}$/', $this->faker->companyNumber());
        }
    }

    public function testVat(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $vat = $this->faker->vat();

            $this->assertMatchesRegularExpression('/^IE\d{7}[A-W][A-I]$/', $vat);
            $this->assertSame($this->expectedCheckLetter(substr($vat, 2, 7), $vat[10]), $vat[9]);
        }
    }

    public function testLegacyVat(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $vat = $this->faker->vat(false);

            $this->assertMatchesRegularExpression('/^IE\d{7}[A-W]$/', $vat);
            $this->assertSame($this->expectedCheckLetter(substr($vat, 2, 7)), $vat[9]);
        }
    }

    public function testCheckLetterMatchesKnownVatNumbers(): void
    {
        $this->assertSame('T', $this->expectedCheckLetter('1234567'));
        $this->assertSame('F', $this->expectedCheckLetter('1234567', 'A'));
    }

    private function expectedCheckLetter(string $digits, string $suffix = ''): string
    {
        $sum = 0;
        for ($i = 0; $i < 7; $i++) {
            $sum += (int) $digits[$i] * (8 - $i);
        }

        if ($suffix !== '') {
            $sum += (ord($suffix) - ord('A') + 1) * 9;
        }

        return 'WABCDEFGHIJKLMNOPQRSTUV'[$sum % 23];
    }
}
