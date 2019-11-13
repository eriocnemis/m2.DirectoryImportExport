<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\ResourceModel\Region;

/**
 * Region delete resource
 */
class Delete extends AbstractResource
{
    /**
     * Delete region from database
     *
     * @param integer $regionId
     * @return void
     */
    public function deleteRegion($regionId)
    {
        $this->getConnection()->delete(
            $this->getMainTable(),
            ['region_id = ?' => $regionId]
        );
    }

    /**
     * Delete labels from database
     *
     * @param integer $regionId
     * @return void
     */
    public function deleteLabel($regionId)
    {
        $this->getConnection()->delete(
            $this->getRegionNameTable(),
            ['region_id = ?' => $regionId]
        );
    }
}
