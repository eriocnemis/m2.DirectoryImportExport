<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\Import\Region\Validator;

use Eriocnemis\DirectoryImportExport\Model\Constant\Field;
use Eriocnemis\DirectoryImportExport\Model\ResourceModel\Region\Delete as RegionResource;
use Eriocnemis\DirectoryImportExport\Model\Import\Validator\ValidatorInterface;

/**
 * Primary key validator
 */
class Primary implements ValidatorInterface
{
    /**
     * Region resource
     *
     * @var RegionResource
     */
    protected $regionResource;

    /**
     * Initialize handler
     *
     * @param RegionResource $regionResource
     */
    public function __construct(
        RegionResource $regionResource
    ) {
        $this->regionResource = $regionResource;
    }

    /**
     * Validate data row
     *
     * @param array $rowData
     * @return array
     */
    public function validate(array $rowData)
    {
        $regionId = $this->regionResource->getRegionId($rowData);
        if (empty($regionId)) {
            return [
                __('Region with specified code and specified country not found.')
            ];
        }
        return [];
    }
}
