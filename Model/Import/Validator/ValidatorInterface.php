<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\Import\Validator;

/**
 * Import validator interface
 */
interface ValidatorInterface
{
    /**
     * Validate data row
     *
     * @param array $rowData
     * @return array
     */
    public function validate(array $rowData);
}
