<?php

namespace Xefi\Faker\EnIe\Tests\Unit;

use Random\Randomizer;
use ReflectionClass;
use Xefi\Faker\Calculators\Iban;
use Xefi\Faker\EnIe\Extensions\FinancialExtension;

final class FinancialExtensionTest extends TestCase
{
    public function testIban(): void
    {
        $financialExtension = new FinancialExtension(new Randomizer());
        $banks = (new ReflectionClass($financialExtension))->getProperty('banks')->getValue($financialExtension);

        for ($i = 0; $i < 100; $i++) {
            $iban = $this->faker->iban();

            $this->assertMatchesRegularExpression('/^IE\d{2}[A-Z]{4}\d{6}\d{8}$/', $iban);
            $this->assertEquals(22, strlen($iban));
            $this->assertArrayHasKey(substr($iban, 4, 4), $banks);
            $this->assertSame($banks[substr($iban, 4, 4)], substr($iban, 8, 2));
            $this->assertTrue(Iban::isValid($iban));
        }
    }

    public function testKnownIrishIbanIsValid(): void
    {
        $this->assertTrue(Iban::isValid('IE29AIBK93115212345678'));
    }
}
