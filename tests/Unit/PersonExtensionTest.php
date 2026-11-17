<?php

namespace Xefi\Faker\EnIe\Tests\Unit;

use Random\Randomizer;
use ReflectionClass;
use Xefi\Faker\Extensions\PersonExtension;

final class PersonExtensionTest extends TestCase
{
    protected array $firstNameMale = [];
    protected array $firstNameFemale = [];
    protected array $lastName = [];
    protected array $titleMale = [];
    protected array $titleFemale = [];

    protected function setUp(): void
    {
        parent::setUp();

        $personExtension = new \Xefi\Faker\EnIe\Extensions\PersonExtension(new Randomizer());
        $reflection = new ReflectionClass($personExtension);

        $this->firstNameMale = $reflection->getProperty('firstNameMale')->getValue($personExtension);
        $this->firstNameFemale = $reflection->getProperty('firstNameFemale')->getValue($personExtension);
        $this->lastName = $reflection->getProperty('lastName')->getValue($personExtension);
        $this->titleMale = $reflection->getProperty('titleMale')->getValue($personExtension);
        $this->titleFemale = $reflection->getProperty('titleFemale')->getValue($personExtension);
    }

    public function testFirstNameFemale(): void
    {
        $results = [];
        for ($i = 0; $i < count($this->firstNameFemale); $i++) {
            $results[] = $this->faker->unique()->firstName(PersonExtension::GENDER_FEMALE);
        }

        $this->assertEqualsCanonicalizing(
            $this->firstNameFemale,
            $results
        );
    }

    public function testFirstNameMale(): void
    {
        $results = [];
        for ($i = 0; $i < count($this->firstNameMale); $i++) {
            $results[] = $this->faker->unique()->firstName(PersonExtension::GENDER_MALE);
        }

        $this->assertEqualsCanonicalizing(
            $this->firstNameMale,
            $results
        );
    }

    public function testFirstName(): void
    {
        $results = [];
        $firstNames = array_unique(array_merge($this->firstNameMale, $this->firstNameFemale));
        for ($i = 0; $i < count($firstNames); $i++) {
            $results[] = $this->faker->unique()->firstName();
        }

        $this->assertEqualsCanonicalizing(
            $firstNames,
            $results
        );
    }

    public function testLastName(): void
    {
        $results = [];
        for ($i = 0; $i < count($this->lastName); $i++) {
            $results[] = $this->faker->unique()->lastName();
        }

        $this->assertEqualsCanonicalizing(
            $this->lastName,
            $results
        );
    }

    public function testName(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $gender = $this->faker->randomElement([null, PersonExtension::GENDER_MALE, PersonExtension::GENDER_FEMALE]);
            $firstNames = match ($gender) {
                PersonExtension::GENDER_MALE => $this->firstNameMale,
                PersonExtension::GENDER_FEMALE => $this->firstNameFemale,
                default => array_merge($this->firstNameMale, $this->firstNameFemale),
            };

            [$firstName, $lastName] = explode(' ', $this->faker->name($gender), 2);

            $this->assertContains($firstName, $firstNames);
            $this->assertContains($lastName, $this->lastName);
        }
    }

    public function testTitle(): void
    {
        $titles = array_unique(array_merge($this->titleFemale, $this->titleMale));

        $results = [];
        for ($i = 0; $i < count($titles); $i++) {
            $results[] = $this->faker->unique()->title();
        }

        $this->assertEqualsCanonicalizing(
            $titles,
            $results
        );
    }

    public function testTitleByGender(): void
    {
        for ($i = 0; $i < 50; $i++) {
            $this->assertContains($this->faker->title(PersonExtension::GENDER_MALE), $this->titleMale);
            $this->assertContains($this->faker->title(PersonExtension::GENDER_FEMALE), $this->titleFemale);
        }
    }

    public function testPpsn(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $ppsn = $this->faker->ppsn();

            $this->assertMatchesRegularExpression('/^\d{7}[A-W]A$/', $ppsn);
            $this->assertSame($this->expectedCheckCharacter(substr($ppsn, 0, 7), 'A'), $ppsn[7]);
        }
    }

    public function testLegacyPpsn(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $ppsn = $this->faker->ppsn(false);

            $this->assertMatchesRegularExpression('/^\d{7}[A-W]$/', $ppsn);
            $this->assertSame($this->expectedCheckCharacter(substr($ppsn, 0, 7)), $ppsn[7]);
        }
    }

    public function testCheckCharacterMatchesKnownPpsns(): void
    {
        $this->assertSame('T', $this->expectedCheckCharacter('1234567'));
        $this->assertSame('F', $this->expectedCheckCharacter('1234567', 'A'));
    }

    private function expectedCheckCharacter(string $digits, string $suffix = ''): string
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
