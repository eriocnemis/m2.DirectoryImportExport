<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Eriocnemis\DirectoryImportExport\Model\ResourceModel\Region;

use Magento\Framework\DataObject;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Eriocnemis\Directory\Model\ResourceModel\Region as RegionResource;
use Eriocnemis\Directory\Model\Region;

/**
 * Region collection
 */
class Collection extends AbstractCollection
{
    /**
     * initialize entity and resource
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Region::class, RegionResource::class);
    }

    /**
     * Retrieve item id
     *
     * @param DataObject $item
     * @return mixed
     */
    protected function _getItemId(DataObject $item)
    {
        return null;
    }

    /**
     * Add labels to result
     *
     * @return $this
     */
    public function addLabelsToResult()
    {
        $this->getSelect()->joinLeft(
            ['n' => $this->getTable('directory_country_region_name')],
            'main_table.region_id=n.region_id',
            ['locale', 'name']
        );
        return $this;
    }
}
