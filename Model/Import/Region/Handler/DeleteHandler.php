<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\Import\Region\Handler;

use Eriocnemis\DirectoryImportExport\Model\ResourceModel\Region\Delete as RegionResource;
use Eriocnemis\DirectoryImportExport\Model\Import\Handler\HandlerInterface;

/**
 * Behavior delete handler
 */
class DeleteHandler implements HandlerInterface
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
     * Executes the procedure
     *
     * @param array $rowData
     * @return void
     */
    public function execute(array $rowData)
    {
        $regionId = $this->regionResource->getRegionId($rowData);
        if (!empty($regionId)) {
            $this->regionResource->deleteLabel($regionId);
            $this->regionResource->deleteRegion($regionId);
        }
    }
}
