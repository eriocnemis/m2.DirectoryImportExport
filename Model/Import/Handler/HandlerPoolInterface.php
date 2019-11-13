<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\Import\Handler;

/**
 * Behavior handlers pool interface
 */
interface HandlerPoolInterface
{
    /**
     * Retrieve handler for specific behavior
     *
     * @param string $behavior
     * @return HandlerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($behavior);
}
