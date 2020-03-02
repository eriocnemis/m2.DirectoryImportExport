<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\Import\Region\Validator;

use Eriocnemis\Directory\Model\Config\Source\Status as StatusSource;
use Eriocnemis\DirectoryImportExport\Model\Constant\Field;
use Eriocnemis\DirectoryImportExport\Model\Import\Validator\ValidatorInterface;

/**
 * Status validator
 */
class Status implements ValidatorInterface
{
    /**
     * Status source
     *
     * @var StatusSource
     */
    protected $statusSource;

    /**
     * Initialize validator
     *
     * @param StatusSource $statusSource
     */
    public function __construct(
        StatusSource $statusSource
    ) {
        $this->statusSource = $statusSource;
    }

    /**
     * Validate data row
     *
     * @param array $rowData
     * @return array
     */
    public function validate(array $rowData)
    {
        return isset($rowData[Field::STATUS])
            ? $this->validateAllow($rowData[Field::STATUS])
            : [];
    }

    /**
     * Check whether status is allowed
     *
     * @param string $status
     * @return array
     */
    protected function validateAllow($status)
    {
        $options = $this->statusSource->toArray();
        if (!isset($options[$status])) {
            return [
                __('Invalid value of %1 provided for the region status field.', $status)
            ];
        }
        return [];
    }
}
