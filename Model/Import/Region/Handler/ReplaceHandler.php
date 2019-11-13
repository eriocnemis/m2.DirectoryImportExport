<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\Import\Region\Handler;

use Eriocnemis\DirectoryImportExport\Model\Constant\Field;
use Eriocnemis\DirectoryImportExport\Model\Import\Handler\HandlerInterface;

/**
 * Behavior replace handler
 */
class ReplaceHandler implements HandlerInterface
{
    /**
     * Delete handler
     *
     * @var DeleteHandler
     */
    protected $deleteHandler;

    /**
     * Append handler
     *
     * @var AppendHandler
     */
    protected $appendHandler;

    /**
     * Array of primary keys of deleted rows as keys and boolean true as values
     *
     * @var array
     */
    protected $deletedRegions = [];

    /**
     * Initialize handler
     *
     * @param DeleteHandler $deleteHandler
     * @param AppendHandler $appendHandler
     */
    public function __construct(
        DeleteHandler $deleteHandler,
        AppendHandler $appendHandler
    ) {
        $this->deleteHandler = $deleteHandler;
        $this->appendHandler = $appendHandler;
    }

    /**
     * Executes the procedure
     *
     * @param array $rowData
     * @return void
     */
    public function execute(array $rowData)
    {
        if (!$this->isDeleted($rowData)) {
            $this->deleteHandler->execute($rowData);
            $this->markAsDeleted($rowData);
        }
        $this->appendHandler->execute($rowData);
    }

    /**
     * Checks that the region has been deleted
     *
     * @param array $rowData
     * @return bool
     */
    protected function isDeleted(array $rowData)
    {
        return isset(
            $this->deletedRegions[$this->getPrimaryKey($rowData)]
        );
    }

    /**
     * Mark as deleted
     *
     * @param array $rowData
     * @return void
     */
    protected function markAsDeleted(array $rowData)
    {
        $this->deletedRegions[$this->getPrimaryKey($rowData)] = true;
    }

    /**
     * Retrieve primary key of region
     *
     * @return string
     */
    protected function getPrimaryKey(array $rowData)
    {
        return $rowData[Field::COUNTRY_ID] . '-' . $rowData[Field::CODE];
    }
}
