<?php

namespace Xefi\Faker\EnIe\Extensions;

use Xefi\Faker\Extensions\FinancialExtension as BaseFinancialExtension;

class FinancialExtension extends BaseFinancialExtension
{
    protected array $banks = [
        'AIBK' => '93', 'BOFI' => '90', 'IPBS' => '99', 'ULSB' => '98', 'EBSI' => '93',
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
     * Generate an Irish IBAN: 4-letter bank code, 6-digit sort code and 8-digit account number.
     *
     * @param string|null $countryCode
     * @param string|null $format      [{d} => digit, {l} => letter, {a} => any]
     *
     * @return string
     */
    public function iban(?string $countryCode = null, ?string $format = null): string
    {
        if ($countryCode === null) {
            $countryCode = 'IE';
        }

        if ($format === null) {
            $bankCode = $this->pickArrayRandomKey($this->banks);

            $format = sprintf(
                '%s%s%s%s',
                $bankCode,
                $this->banks[$bankCode],
                str_repeat('{d}', 4),
                str_repeat('{d}', 8)
            );
        }

        return parent::iban($countryCode, $format);
    }
}
