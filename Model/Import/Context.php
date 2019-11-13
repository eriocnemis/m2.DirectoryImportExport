<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\Import;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Stdlib\StringUtils;
use Magento\ImportExport\Model\ImportFactory;
use Magento\ImportExport\Model\Import\ErrorProcessing\ProcessingErrorAggregatorInterface;
use Magento\ImportExport\Model\ResourceModel\Helper as ResourceHelper;

/**
 * Import context
 */
class Context
{
    /**
     * Magento string lib
     *
     * @var StringUtils
     */
    protected $string;

    /**
     * Core store config
     *
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Import factory
     *
     * @var ImportFactory
     */
    protected $importFactory;

    /**
     * Resource helper
     *
     * @var ResourceHelper
     */
    protected $resourceHelper;

    /**
     * Resource connection
     *
     * @var ResourceConnection
     */
    protected $resource;

    /**
     * Error aggregator
     *
     * @var ProcessingErrorAggregatorInterface
     */
    protected $errorAggregator;

    /**
     * Initialize context
     *
     * @param StringUtils $string
     * @param ScopeConfigInterface $scopeConfig
     * @param ImportFactory $importFactory
     * @param ResourceHelper $resourceHelper
     * @param ResourceConnection $resource
     * @param ProcessingErrorAggregatorInterface $errorAggregator
     */
    public function __construct(
        StringUtils $string,
        ScopeConfigInterface $scopeConfig,
        ImportFactory $importFactory,
        ResourceHelper $resourceHelper,
        ResourceConnection $resource,
        ProcessingErrorAggregatorInterface $errorAggregator
    ) {
        $this->string = $string;
        $this->scopeConfig = $scopeConfig;
        $this->importFactory = $importFactory;
        $this->resourceHelper = $resourceHelper;
        $this->resource = $resource;
        $this->errorAggregator = $errorAggregator;
    }

    /**
     * Retrieve string lib
     *
     * @return StringUtils
     */
    public function getStringUtils()
    {
        return $this->string;
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
     * Retrieve import factory
     *
     * @return ImportFactory
     */
    public function getImportFactory()
    {
        return $this->importFactory;
    }

    /**
     * Retrieve resource helper
     *
     * @return ResourceHelper
     */
    public function getResourceHelper()
    {
        return $this->resourceHelper;
    }

    /**
     * Retrieve resource connection
     *
     * @return ResourceConnection
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Retrieve processing error aggregator
     *
     * @return ProcessingErrorAggregatorInterface
     */
    public function getErrorAggregator()
    {
        return $this->errorAggregator;
    }
}
