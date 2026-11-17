<?php

namespace Xefi\Faker\EnIe\Extensions;

use Xefi\Faker\Extensions\Extension;

class CompanyExtension extends Extension
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

    private array $companies = [
        'Shannon Aerospace Ltd', 'Liffey Valley Logistics Ltd', 'Emerald Isle Software DAC',
        'Wild Atlantic Seafoods Ltd', 'Burren Dairy Teoranta', 'Connemara Marble Works Ltd',
        'Kerry Hills Farm Produce Ltd', 'Slaney Engineering DAC', 'Boyne Valley Foods Ltd',
        'Galway Bay Analytics Ltd', 'Corrib Construction Ltd', 'Wicklow Way Tours Ltd',
        'Croagh Patrick Outdoor Ltd', 'Barrow Brewing Company Ltd', 'Dalkey Capital DAC',
        'Cliffs of Moher Hospitality Ltd', 'Shamrock Medical Devices DAC', 'Na Sceirí Teicneolaíocht Teoranta',
        'Ring of Kerry Coaches Ltd', 'Lough Derg Marine Ltd', 'Dublin Docklands Property PLC',
        'Atlantic Edge Energy DAC', 'Midlands Peat Products Ltd', 'Cork Harbour Pharma Ltd',
        'Kilkenny Craft Designs Ltd', 'Donegal Tweed Mills Ltd', 'Inishowen Fisheries UC',
        'Tara Mines Exploration PLC', 'Suir Valley Insurance DAC', 'Mourne View Consulting Ltd',
    ];

    /**
     * Return a random company name.
     *
     * @return string
     */
    public function company(): string
    {
        return $this->pickArrayRandomElement($this->companies);
    }

    /**
     * Generate a Companies Registration Office (CRO) number.
     *
     * @return string
     */
    public function companyNumber(): string
    {
        return (string) $this->randomizer->getInt(100000, 799999);
    }

    /**
     * Generate an Irish VAT number ("IE" + 7 digits + check letter + optional letter) with a valid modulus 23 check letter.
     *
     * @param bool $newFormat Whether to use the 9-character format with a trailing letter from A to I.
     *
     * @return string
     */
    public function vat(bool $newFormat = true): string
    {
        $digits = $this->randomizer->getBytesFromString('0123456789', 7);
        $suffix = $newFormat ? $this->pickArrayRandomElement(range('A', 'I')) : '';

        $sum = 0;
        foreach (str_split($digits) as $index => $digit) {
            $sum += (int) $digit * (8 - $index);
        }

        if ($suffix !== '') {
            $sum += (ord($suffix) - 64) * 9;
        }

        return 'IE'.$digits.'WABCDEFGHIJKLMNOPQRSTUV'[$sum % 23].$suffix;
    }
}
