<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\Import\Handler;

/**
 * Behavior handler interface
 */
interface HandlerInterface
{
    /**
     * Executes the procedure
     *
     * @param array $rowData
     * @return void
     */
    public function execute(array $rowData);
}
