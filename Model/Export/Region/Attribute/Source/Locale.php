<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\Export\Region\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Config\Model\Config\Source\Locale as LocaleSource;

/**
 * Locale attribute source
 */
class Locale extends AbstractSource
{
    /**
     * Locale source
     *
     * @var LocaleSource
     */
    protected $localeSource;

    /**
     * Initialize source
     *
     * @param LocaleSource $localeSource
     */
    public function __construct(
        LocaleSource $localeSource
    ) {
        $this->localeSource = $localeSource;
    }

    /**
     * Retrieve options as array
     *
     * @return mixed[]
     */
    public function getAllOptions()
    {
        return $this->localeSource->toOptionArray();
    }
}
