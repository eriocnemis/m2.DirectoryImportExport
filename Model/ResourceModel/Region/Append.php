<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\ResourceModel\Region;

use Eriocnemis\DirectoryImportExport\Model\Constant\Field;

/**
 * Region append resource
 */
class Append extends AbstractResource
{
    /**
     * Save region to database
     *
     * @param array $rowData
     * @return integer
     */
    public function saveRegion(array $rowData)
    {
        $this->getConnection()->insert(
            $this->getMainTable(),
            $this->getRegionBind($rowData)
        );

        return (int)$this->getConnection()->lastInsertId(
            $this->getMainTable()
        );
    }

    /**
     * Retrieve region bind data
     *
     * @param array $rowData
     * @return array
     */
    protected function getRegionBind(array $rowData)
    {
        return [
            'country_id' => $rowData[Field::COUNTRY_ID],
            'code' => $rowData[Field::CODE],
            'default_name' => $rowData[Field::NAME]
        ];
    }

    /**
     * Save label to database
     *
     * @param array $rowData
     * @param integer $regionId
     * @return void
     */
    public function saveLabel(array $rowData, $regionId)
    {
        $this->getConnection()->insertOnDuplicate(
            $this->getRegionNameTable(),
            $this->getLabelBind($rowData, $regionId)
        );
    }

    /**
     * Retrieve label bind data
     *
     * @param array $rowData
     * @param integer $regionId
     * @return array
     */
    protected function getLabelBind(array $rowData, $regionId)
    {
        return [
            'region_id' => $regionId,
            'locale' => $rowData[Field::LOCALE],
            'name' => $rowData[Field::NAME]
        ];
    }
}
