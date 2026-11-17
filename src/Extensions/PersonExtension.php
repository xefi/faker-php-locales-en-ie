<?php

namespace Xefi\Faker\EnIe\Extensions;

use Xefi\Faker\Extensions\PersonExtension as BasePersonExtension;

class PersonExtension extends BasePersonExtension
{
    /**
     * The extension locale.
     *
     * @return string|null
     */
    public function getLocale(): ?string
    {
        return 'en_IE';
    }

    protected $firstNameMale = [
        'Seán', 'Patrick', 'Conor', 'Ciarán', 'Darragh', 'Cian', 'Oisín', 'Liam', 'Eoin', 'Niall',
        'Cillian', 'Fionn', 'Tadhg', 'Ruairí', 'Dónal', 'Diarmuid', 'Pádraig', 'Colm', 'Brendan', 'Declan',
        'Kevin', 'Fergal', 'Éamon', 'Shane', 'Aidan', 'Rory', 'Ronan', 'Killian', 'Daithí', 'Cathal',
        'Senan', 'Odhrán', 'Michael', 'John', 'James', 'Jack', 'Dermot', 'Brian', 'Barry', 'Kieran',
    ];

    protected $firstNameFemale = [
        'Aoife', 'Saoirse', 'Siobhán', 'Niamh', 'Ciara', 'Sinéad', 'Róisín', 'Orla', 'Gráinne', 'Caoimhe',
        'Clodagh', 'Aisling', 'Méabh', 'Éabha', 'Sadhbh', 'Fiadh', 'Áine', 'Úna', 'Deirdre', 'Eimear',
        'Nuala', 'Bríd', 'Maeve', 'Emer', 'Muireann', 'Laoise', 'Clíona', 'Ailbhe', 'Mairéad', 'Síle',
        'Doireann', 'Orlaith', 'Sorcha', 'Fionnuala', 'Grace', 'Emma', 'Mary', 'Kate', 'Sarah', 'Ellen',
    ];

    protected $lastName = [
        'Murphy', 'Kelly', 'O\'Sullivan', 'Walsh', 'Smith', 'O\'Brien', 'Byrne', 'Ryan', 'O\'Connor', 'O\'Neill',
        'O\'Reilly', 'Doyle', 'McCarthy', 'Gallagher', 'O\'Doherty', 'Kennedy', 'Lynch', 'Murray', 'Quinn', 'Moore',
        'McLoughlin', 'O\'Carroll', 'Connolly', 'Daly', 'O\'Connell', 'Wilson', 'Dunne', 'Brennan', 'Burke', 'Collins',
        'Campbell', 'Clarke', 'Johnston', 'Hughes', 'O\'Farrell', 'Fitzgerald', 'Brown', 'Martin', 'Maguire', 'Nolan',
    ];

    protected $titleMale = ['Mr', 'Dr', 'Prof', 'Rev', 'Fr'];

    protected $titleFemale = ['Ms', 'Mrs', 'Miss', 'Dr', 'Prof', 'Rev', 'Sr'];

    /**
     * Generate a Personal Public Service Number (PPSN) with a valid modulus 23 check character.
     *
     * @param bool $newFormat Whether to use the 9-character format introduced in 2013 (second letter "A").
     *
     * @return string
     */
    public function ppsn(bool $newFormat = true): string
    {
        $digits = $this->randomizer->getBytesFromString('0123456789', 7);
        $suffix = $newFormat ? 'A' : '';

        return $digits.$this->checkCharacter($digits, $suffix).$suffix;
    }

    /**
     * Compute the modulus 23 check character shared by the PPSN and the Irish VAT number.
     *
     * @param string $digits The 7 leading digits.
     * @param string $suffix The optional trailing letter, weighted by 9 (A = 1, B = 2, ...).
     *
     * @return string
     */
    protected function checkCharacter(string $digits, string $suffix = ''): string
    {
        $sum = 0;
        foreach (str_split($digits) as $index => $digit) {
            $sum += (int) $digit * (8 - $index);
        }

        if ($suffix !== '') {
            $sum += (ord($suffix) - 64) * 9;
        }

        return 'WABCDEFGHIJKLMNOPQRSTUV'[$sum % 23];
    }
}
