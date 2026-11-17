<?php

namespace Xefi\Faker\EnIe\Tests\Unit;

final class PhoneExtensionTest extends TestCase
{
    public function testPhoneNumber(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $this->assertMatchesRegularExpression('/^0(1\d{7}|(21|56|8[35679])\d{7}|(91|61|51)\d{6})$/', $this->faker->phoneNumber());
        }
    }

    public function testCellPhoneNumber(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $this->assertMatchesRegularExpression('/^08[35679]\d{7}$/', $this->faker->cellPhoneNumber());
            $this->assertMatchesRegularExpression('/^08[35679] \d{3} \d{4}$/', $this->faker->spacedCellPhoneNumber());
        }
    }

    public function testLandlinePhoneNumber(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $this->assertMatchesRegularExpression('/^0(1 \d{3} \d{4}|(21|56) \d{3} \d{4}|(91|61|51) \d{3} \d{3})$/', $this->faker->spacedLandlinePhoneNumber());
        }
    }

    public function testIndicatoredPhoneNumber(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $this->assertMatchesRegularExpression('/^\+353[1-9]\d{7,8}$/', $this->faker->indicatoredPhoneNumber());
            $this->assertMatchesRegularExpression('/^\+353 8[35679] \d{3} \d{4}$/', $this->faker->spacedIndicatoredCellPhoneNumber());
        }
    }
}
