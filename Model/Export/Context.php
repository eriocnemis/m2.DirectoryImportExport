<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\Export;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\ImportExport\Model\Export\Factory as CollectionFactory;
use Magento\ImportExport\Model\ResourceModel\CollectionByPagesIteratorFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Export context
 */
class Context
{
    /**
     * Core store config
     *
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Collection factory
     *
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Iterator factory
     *
     * @var CollectionByPagesIteratorFactory
     */
    protected $iteratorFactory;

    /**
     * Initialize context
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param CollectionFactory $collectionFactory
     * @param CollectionByPagesIteratorFactory $iteratorFactory
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        CollectionFactory $collectionFactory,
        CollectionByPagesIteratorFactory $iteratorFactory
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->collectionFactory = $collectionFactory;
        $this->iteratorFactory = $iteratorFactory;
    }

    /**
     * Retrieve core store config
     *
     * @return ScopeConfigInterface
     */
    public function getScopeConfig()
    {
        return $this->scopeConfig;
    }

    /**
     * Retrieve store manager
     *
     * @return StoreManagerInterface
     */
    public function getStoreManager()
    {
        return $this->storeManager;
    }

    /**
     * Retrieve collection factory
     *
     * @return CollectionFactory
     */
    public function getCollectionFactory()
    {
        return $this->collectionFactory;
    }

    /**
     * Retrieve iterator factory
     *
     * @return CollectionByPagesIteratorFactory
     */
    public function getIteratorFactory()
    {
        return $this->iteratorFactory;
    }
}
 
