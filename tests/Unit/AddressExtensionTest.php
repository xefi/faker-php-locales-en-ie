<?php

namespace Xefi\Faker\EnIe\Tests\Unit;

use Random\Randomizer;
use ReflectionClass;
use Xefi\Faker\EnIe\Extensions\AddressExtension;

final class AddressExtensionTest extends TestCase
{
    private const EIRCODE_PATTERN = '([AC-FHKNPRTV-Y]\d{2}|D6W) ([AC-FHKNPRTV-Y][0-9AC-FHKNPRTV-Y]{3})';

    protected array $provinces = [];
    protected array $counties = [];
    protected array $cities = [];
    protected array $routingKeys = [];
    protected array $streetTypes = [];
    protected array $streetNames = [];

    protected function setUp(): void
    {
        parent::setUp();

        $addressExtension = new AddressExtension(new Randomizer());
        $reflection = new ReflectionClass($addressExtension);

        $this->provinces = $reflection->getProperty('provinces')->getValue($addressExtension);
        $this->counties = $reflection->getProperty('counties')->getValue($addressExtension);
        $this->cities = $reflection->getProperty('cities')->getValue($addressExtension);
        $this->routingKeys = $reflection->getProperty('routingKeys')->getValue($addressExtension);
        $this->streetTypes = $reflection->getProperty('streetTypes')->getValue($addressExtension);
        $this->streetNames = $reflection->getProperty('streetNames')->getValue($addressExtension);
    }

    public function testProvince(): void
    {
        $results = [];
        for ($i = 0; $i < count($this->provinces); $i++) {
            $results[] = $this->faker->unique()->province();
        }

        $this->assertEqualsCanonicalizing(
            $this->provinces,
            $results
        );
    }

    public function testCounty(): void
    {
        $results = [];
        for ($i = 0; $i < count($this->counties); $i++) {
            $results[] = $this->faker->unique()->county();
        }

        $this->assertEqualsCanonicalizing(
            $this->counties,
            $results
        );
    }

    public function testCity(): void
    {
        $results = [];
        for ($i = 0; $i < count($this->cities); $i++) {
            $results[] = $this->faker->unique()->city();
        }

        $this->assertEqualsCanonicalizing(
            array_keys($this->cities),
            $results
        );
    }

    public function testCitiesHaveACountyAndRoutingKeys(): void
    {
        foreach ($this->cities as $city => $county) {
            $this->assertContains($county, $this->counties);
            $this->assertArrayHasKey($city, $this->routingKeys);
        }
    }

    public function testPostcode(): void
    {
        $routingKeys = array_merge(...array_values($this->routingKeys));

        for ($i = 0; $i < 200; $i++) {
            $postcode = $this->faker->postcode();

            $this->assertMatchesRegularExpression('/^'.self::EIRCODE_PATTERN.'$/', $postcode);
            $this->assertContains(substr($postcode, 0, 3), $routingKeys);
        }
    }

    public function testHouseNumber(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $houseNumber = $this->faker->houseNumber();

            $this->assertGreaterThanOrEqual(1, $houseNumber);
            $this->assertLessThanOrEqual(200, $houseNumber);
        }
    }

    public function testStreetName(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $streetName = $this->faker->streetName();
            $separator = strrpos($streetName, ' ');

            $this->assertContains(substr($streetName, 0, $separator), $this->streetNames);
            $this->assertContains(substr($streetName, $separator + 1), $this->streetTypes);
        }
    }

    public function testStreetAddress(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $this->assertMatchesRegularExpression("/^\d{1,3} [A-Za-z' ]+$/", $this->faker->streetAddress());
        }
    }

    public function testFullAddress(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $fullAddress = $this->faker->fullAddress();

            $this->assertMatchesRegularExpression("/^\d{1,3} [A-Za-z' ]+, [A-Za-z ]+, Co\. [A-Za-z]+, ".self::EIRCODE_PATTERN.'$/', $fullAddress);

            preg_match('/, ([A-Za-z ]+), Co\. ([A-Za-z]+), (\S{3}) \S{4}$/', $fullAddress, $matches);
            [, $city, $county, $routingKey] = $matches;

            $this->assertSame($this->cities[$city], $county);
            $this->assertContains($routingKey, $this->routingKeys[$city]);
        }
    }
}
