<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\Import\Validator;

/**
 * Behavior validator pool interface
 */
interface ValidatorPoolInterface
{
    /**
     * Retrieve validator for specific behavior
     *
     * @param string $behavior
     * @return ValidatorInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($behavior);
}
