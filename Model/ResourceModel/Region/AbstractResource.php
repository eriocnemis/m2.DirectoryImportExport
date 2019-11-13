<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\ResourceModel\Region;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Eriocnemis\DirectoryImportExport\Model\Constant\Field;

/**
 * Region abstract resource
 */
class AbstractResource extends AbstractDb
{
    /**
     * Table with localized region names
     *
     * @var string
     */
    protected $regionNameTable;

    /**
     * Initialize resource
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('directory_country_region', 'region_id');
    }

    /**
     * Retrieve RegionId if region is present in database
     *
     * @param array $rowData
     * @return integer
     */
    public function getRegionId(array $rowData)
    {
        /** @var \Magento\Framework\DB\Select $select */
        $select = $this->getConnection()->select();
        $select->from([$this->getMainTable()], 'region_id')
            ->where('country_id = ?', $rowData[Field::COUNTRY_ID])
            ->where('code = ?', $rowData[Field::CODE]);

        return (int)$this->getConnection()->fetchOne($select);
    }

    /**
     * Retrieve labels table name
     *
     * @return string
     */
    protected function getRegionNameTable()
    {
        if (null === $this->regionNameTable) {
            $this->regionNameTable = $this->getTable('directory_country_region_name');
        }
        return $this->regionNameTable;
    }
}
