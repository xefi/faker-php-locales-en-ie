<?php

namespace Xefi\Faker\EnIe\Extensions;

use Xefi\Faker\Extensions\Extension;

class AddressExtension extends Extension
{
    protected $provinces = ['Connacht', 'Leinster', 'Munster', 'Ulster'];

    protected $counties = [
        'Carlow', 'Cavan', 'Clare', 'Cork', 'Donegal', 'Dublin', 'Galway', 'Kerry', 'Kildare', 'Kilkenny',
        'Laois', 'Leitrim', 'Limerick', 'Longford', 'Louth', 'Mayo', 'Meath', 'Monaghan', 'Offaly', 'Roscommon',
        'Sligo', 'Tipperary', 'Waterford', 'Westmeath', 'Wexford', 'Wicklow',
    ];

    protected $cities = [
        'Dublin' => 'Dublin', 'Cork' => 'Cork', 'Limerick' => 'Limerick', 'Galway' => 'Galway', 'Waterford' => 'Waterford',
        'Drogheda' => 'Louth', 'Dundalk' => 'Louth', 'Swords' => 'Dublin', 'Navan' => 'Meath', 'Bray' => 'Wicklow',
        'Ennis' => 'Clare', 'Kilkenny' => 'Kilkenny', 'Tralee' => 'Kerry', 'Carlow' => 'Carlow', 'Naas' => 'Kildare',
        'Athlone' => 'Westmeath', 'Portlaoise' => 'Laois', 'Mullingar' => 'Westmeath', 'Wexford' => 'Wexford',
        'Letterkenny' => 'Donegal', 'Sligo' => 'Sligo', 'Clonmel' => 'Tipperary', 'Killarney' => 'Kerry',
        'Tullamore' => 'Offaly', 'Castlebar' => 'Mayo', 'Cavan' => 'Cavan', 'Monaghan' => 'Monaghan',
        'Longford' => 'Longford', 'Ballina' => 'Mayo', 'Newbridge' => 'Kildare',
    ];

    protected $routingKeys = [
        'Dublin' => [
            'D01', 'D02', 'D03', 'D04', 'D05', 'D06', 'D6W', 'D07', 'D08', 'D09', 'D10', 'D11', 'D12',
            'D13', 'D14', 'D15', 'D16', 'D17', 'D18', 'D20', 'D22', 'D24',
        ],
        'Cork' => ['T12', 'T23'], 'Limerick' => ['V94'], 'Galway' => ['H91'], 'Waterford' => ['X91'],
        'Drogheda' => ['A92'], 'Dundalk' => ['A91'], 'Swords' => ['K67'], 'Navan' => ['C15'], 'Bray' => ['A98'],
        'Ennis' => ['V95'], 'Kilkenny' => ['R95'], 'Tralee' => ['V92'], 'Carlow' => ['R93'], 'Naas' => ['W91'],
        'Athlone' => ['N37'], 'Portlaoise' => ['R32'], 'Mullingar' => ['N91'], 'Wexford' => ['Y35'],
        'Letterkenny' => ['F92'], 'Sligo' => ['F91'], 'Clonmel' => ['E91'], 'Killarney' => ['V93'],
        'Tullamore' => ['R35'], 'Castlebar' => ['F23'], 'Cavan' => ['H12'], 'Monaghan' => ['H18'],
        'Longford' => ['N39'], 'Ballina' => ['F26'], 'Newbridge' => ['W12'],
    ];

    protected $eircodeLetters = 'ACDEFHKNPRTVWXY';

    protected $streetTypes = [
        'Street', 'Road', 'Avenue', 'Lane', 'Terrace', 'Park', 'Quay', 'Square', 'Place', 'Hill', 'Row',
        'Crescent', 'Close', 'Drive', 'Grove',
    ];

    protected $streetNames = [
        'O\'Connell', 'Grafton', 'Dame', 'Patrick', 'Main', 'Church', 'Bridge', 'Mill', 'Abbey', 'Castle',
        'Henry', 'Shop', 'Eyre', 'Pearse', 'Parnell', 'Thomas', 'Dominick', 'Barrack', 'Market', 'Chapel',
        'Fair', 'Green', 'College', 'Ormond', 'Merrion', 'Baggot', 'Leeson', 'Harcourt', 'Talbot', 'Gardiner',
        'Sarsfield', 'Wolfe Tone', 'Emmet', 'Davitt', 'Connolly', 'Clancy', 'Mallow', 'Shandon',
    ];

    /**
     * The extension locale.
     *
     * @return string|null
     */
    public function getLocale(): ?string
    {
        return 'en_IE';
    }

    /**
     * Return a random province.
     *
     * @return string
     */
    public function province(): string
    {
        return $this->pickArrayRandomElement($this->provinces);
    }

    /**
     * Return a random county of the Republic of Ireland.
     *
     * @return string
     */
    public function county(): string
    {
        return $this->pickArrayRandomElement($this->counties);
    }

    /**
     * Return a random city or town.
     *
     * @return string
     */
    public function city(): string
    {
        return $this->pickArrayRandomKey($this->cities);
    }

    /**
     * Return a random Eircode: a routing key followed by a 4-character unique identifier starting with a letter.
     *
     * @return string
     */
    public function postcode(): string
    {
        return $this->eircodeForCity($this->pickArrayRandomKey($this->routingKeys));
    }

    /**
     * Return a random house number.
     *
     * @return int
     */
    public function houseNumber(): int
    {
        return $this->randomizer->getInt(1, 200);
    }

    /**
     * Return a random street name followed by its street type.
     *
     * @return string
     */
    public function streetName(): string
    {
        return sprintf(
            '%s %s',
            $this->pickArrayRandomElement($this->streetNames),
            $this->pickArrayRandomElement($this->streetTypes)
        );
    }

    /**
     * Return a random street address.
     *
     * @return string
     */
    public function streetAddress(): string
    {
        return sprintf('%d %s', $this->houseNumber(), $this->streetName());
    }

    /**
     * Return a full address on one line: street address, town, county and Eircode.
     *
     * @return string
     */
    public function fullAddress(): string
    {
        $city = $this->city();

        return sprintf('%s, %s, Co. %s, %s', $this->streetAddress(), $city, $this->cities[$city], $this->eircodeForCity($city));
    }

    /**
     * Return a random Eircode using one of the routing keys of the given city.
     *
     * @param string $city
     *
     * @return string
     */
    protected function eircodeForCity(string $city): string
    {
        return sprintf(
            '%s %s%s',
            $this->pickArrayRandomElement($this->routingKeys[$city]),
            $this->randomizer->getBytesFromString($this->eircodeLetters, 1),
            $this->randomizer->getBytesFromString('0123456789'.$this->eircodeLetters, 3)
        );
    }
}
