<?php

namespace Xefi\Faker\EnIe\Extensions;

use Xefi\Faker\Extensions\PhoneExtension as BasePhoneExtension;

class PhoneExtension extends BasePhoneExtension
{
    public string $defaultPrefix = '0';

    public string $indicator = '+353';

    protected array $landlineFormats = [
        '1{separator}{d}{d}{d}{separator}{d}{d}{d}{d}',
        '21{separator}{d}{d}{d}{separator}{d}{d}{d}{d}',
        '56{separator}{d}{d}{d}{separator}{d}{d}{d}{d}',
        '91{separator}{d}{d}{d}{separator}{d}{d}{d}',
        '61{separator}{d}{d}{d}{separator}{d}{d}{d}',
        '51{separator}{d}{d}{d}{separator}{d}{d}{d}',
    ];

    protected array $cellFormats = [
        '83{separator}{d}{d}{d}{separator}{d}{d}{d}{d}',
        '85{separator}{d}{d}{d}{separator}{d}{d}{d}{d}',
        '86{separator}{d}{d}{d}{separator}{d}{d}{d}{d}',
        '87{separator}{d}{d}{d}{separator}{d}{d}{d}{d}',
        '89{separator}{d}{d}{d}{separator}{d}{d}{d}{d}',
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
     * Generate a phone number, dropping the trunk prefix "0" in favour of the separated "+353" indicator.
     *
     * @param string|null $format
     * @param string      $separator
     * @param string|null $prefix
     *
     * @return string
     */
    public function phoneNumber(?string $format = null, string $separator = '', ?string $prefix = null): string
    {
        if ($format === null) {
            $format = $this->pickArrayRandomElement(array_merge($this->landlineFormats, $this->cellFormats));
        }

        if ($prefix === $this->indicator) {
            $prefix .= $separator;
        }

        return parent::phoneNumber($format, $separator, $prefix);
    }
}
