<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\Import\Region\Validator;

use Magento\Framework\Locale\ConfigInterface;
use Eriocnemis\DirectoryImportExport\Model\Constant\Field;
use Eriocnemis\DirectoryImportExport\Model\Import\Validator\ValidatorInterface;

/**
 * Locale validator
 */
class Locale implements ValidatorInterface
{
    /**
     * Locale config
     *
     * @var ConfigInterface
     */
    protected $config;

    /**
     * Initialize validator
     *
     * @param ConfigInterface $config
     */
    public function __construct(
        ConfigInterface $config
    ) {
        $this->config = $config;
    }

    /**
     * Validate data row
     *
     * @param array $rowData
     * @return array
     */
    public function validate(array $rowData)
    {
        $errors = [];
        $errors += $this->validateEmpty($rowData[Field::LOCALE]);
        $errors += $this->validateAllow($rowData[Field::LOCALE]);

        return $errors;
    }

    /**
     * Check whether locale is empty
     *
     * @param string $locale
     * @return array
     */
    protected function validateEmpty($locale)
    {
        if (!\Zend_Validate::is($locale, 'NotEmpty')) {
            return [
                __('Region locale field is empty.')
            ];
        }
        return [];
    }

    /**
     * Check whether locale is allowed
     *
     * @param string $locale
     * @return array
     */
    protected function validateAllow($locale)
    {
        if (!in_array($locale, $this->config->getAllowedLocales(), true)) {
            return [
                __('Invalid value of %1 provided for the region locale field.', $locale)
            ];
        }
        return [];
    }
}
