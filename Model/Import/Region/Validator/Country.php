<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\Import\Region\Validator;

use Magento\Directory\Api\CountryInformationAcquirerInterface;
use Eriocnemis\DirectoryImportExport\Model\Constant\Field;
use Eriocnemis\DirectoryImportExport\Model\Import\Validator\ValidatorInterface;

/**
 * Country validator
 */
class Country implements ValidatorInterface
{
    /**
     * Country repository
     *
     * @var CountryInformationAcquirerInterface
     */
    protected $repository;

    /**
     * Initialize validator
     *
     * @param CountryInformationAcquirerInterface $repository
     */
    public function __construct(
        CountryInformationAcquirerInterface $repository
    ) {
        $this->repository = $repository;
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
        $errors += $this->validateEmpty($rowData[Field::COUNTRY_ID]);
        $errors += $this->validateAllow($rowData[Field::COUNTRY_ID]);

        return $errors;
    }

    /**
     * Check whether country is empty
     *
     * @param string $countryId
     * @return array
     */
    protected function validateEmpty($countryId)
    {
        if (!\Zend_Validate::is($countryId, 'NotEmpty')) {
            return [
                __('Region country field is empty.')
            ];
        }
        return [];
    }

    /**
     * Check whether country is allowed
     *
     * @param string $countryId
     * @return array
     */
    protected function validateAllow($countryId)
    {
        try {
            $this->repository->getCountryInfo($countryId);
        } catch (\Exception $e) {
            return [
                __('Invalid value of %1 provided for the region country field.', $countryId)
            ];
        }
        return [];
    }
}
