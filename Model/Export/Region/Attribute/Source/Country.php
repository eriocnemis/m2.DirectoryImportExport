<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\Export\Region\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Config\Model\Config\Source\Locale\Country as CountrySource;

/**
 * Country attribute source
 */
class Country extends AbstractSource
{
    /**
     * Country source
     *
     * @var CountrySource
     */
    protected $countrySource;

    /**
     * Initialize source
     *
     * @param CountrySource $countrySource
     */
    public function __construct(
        CountrySource $countrySource
    ) {
        $this->countrySource = $countrySource;
    }

    /**
     * Retrieve options as array
     *
     * @return mixed[]
     */
    public function getAllOptions()
    {
        return $this->countrySource->toOptionArray();
    }
}
