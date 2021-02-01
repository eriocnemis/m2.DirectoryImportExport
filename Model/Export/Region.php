<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\Export;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\ImportExport\Model\Export\AbstractEntity;
use Magento\ImportExport\Model\Export;
use Eriocnemis\DirectoryImportExport\Model\ResourceModel\Region\CollectionFactory;

/**
 * Region export
 */
class Region extends AbstractEntity
{
    /**
     * Column country id
     */
    const COLUMN_COUNTRY_ID = 'country_id';

    /**
     * Column code
     */
    const COLUMN_CODE = 'code';

    /**
     * Column locale
     */
    const COLUMN_LOCALE = 'locale';

    /**
     * Column name
     */
    const COLUMN_NAME = 'name';

    /**
     * Permanent entity columns
     *
     * @var string[]
     */
    protected $_permanentAttributes = [
        self::COLUMN_COUNTRY_ID,
        self::COLUMN_CODE,
        self::COLUMN_LOCALE
    ];

    /**
     * Entity type
     *
     * @var string
     */
    protected $entity = 'directory_region';

    /**
     * Entity collection factory
     *
     * @var string
     */
    protected $collectionFactory;

    /**
     * Header columns names
     *
     * @var string[]
     */
    protected $headerColumns;

    /**
     * Attribute config
     *
     * @var mixed[]
     */
    private $attributeConfig;

    /**
     * Initialize export
     *
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param mixed[] $attributeConfig
     * @param mixed[] $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        array $attributeConfig = [],
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->attributeConfig = $attributeConfig;

        parent::__construct(
            $context->getScopeConfig(),
            $context->getStoreManager(),
            $context->getCollectionFactory(),
            $context->getIteratorFactory(),
            $data
        );
    }

    /**
     * Export process
     *
     * @return array|boolean
     */
    public function export()
    {
        $collection = $this->_getEntityCollection();
        $this->prepareEntityCollection($collection);

        $this->getWriter()->setHeaderCols(
            $this->_getHeaderColumns()
        );

        if ($collection->getSize()) {
            $this->_exportCollectionByPages($collection);
        }
        return $this->getWriter()->getContents();
    }

    /**
     * Export one item
     *
     * @param AbstractModel $item
     * @return void
     */
    public function exportItem($item)
    {
        $this->getWriter()->writeRow($item->getData());
        $this->_processedEntitiesCount++;
    }

    /**
     * Apply filter to collection and add not skipped attributes to select
     *
     * @param AbstractCollection $collection
     * @return void
     */
    protected function prepareEntityCollection(AbstractCollection $collection)
    {
        $this->filterEntityCollection($collection);
    }

    /**
     * Apply filter to collection
     *
     * @param AbstractCollection $collection
     * @return void
     */
    public function filterEntityCollection(AbstractCollection $collection)
    {
        $filter = $this->getFilter();
        $attributeCollection = $this->filterAttributeCollection(
            $this->getAttributeCollection()
        );
        foreach ($attributeCollection as $attribute) {
            $field = $attribute->getAttributeCode();
            /* filter applying */
            if (!isset($filter[$field])) {
                continue;
            }
            $type = Export::getAttributeFilterType($attribute);
            /* type selector */
            switch ($type) {
                case Export::FILTER_TYPE_SELECT:
                    $this->addSelectTypeFilter($collection, $filter[$field], $field);
                    break;
                case Export::FILTER_TYPE_INPUT:
                    $this->addInputTypeFilter($collection, $filter[$field], $field);
                    break;
                case Export::FILTER_TYPE_DATE:
                    $this->addDateTypeFilter($collection, $filter[$field], $field);
                    break;
                case Export::FILTER_TYPE_NUMBER:
                    $this->addNumberTypeFilter($collection, $filter[$field], $field);
                    break;
            }
        }
    }

    /**
     * Retrieve filter data
     *
     * @return array
     */
    protected function getFilter()
    {
        $filter = $this->_parameters[Export::FILTER_ELEMENT_GROUP] ?? null;
        return is_array($filter) ? $filter : [];
    }

    /**
     * Add select type filter
     *
     * @param AbstractCollection $collection
     * @param mixed $value
     * @param string $field
     * @return void
     */
    protected function addSelectTypeFilter(AbstractCollection $collection, $value, $field)
    {
        if (is_scalar($value) && trim($value) !== '') {
            $collection->addFieldToFilter($field, ['eq' => $value]);
        }
    }

    /**
     * Add input type filter
     *
     * @param AbstractCollection $collection
     * @param mixed $value
     * @param string $field
     * @return void
     */
    protected function addInputTypeFilter(AbstractCollection $collection, $value, $field)
    {
        if (is_scalar($value) && trim($value) !== '') {
            $collection->addFieldToFilter($field, ['like' => "%{$value}%"]);
        }
    }

    /**
     * Add date type filter
     *
     * @param AbstractCollection $collection
     * @param mixed $value
     * @param string $field
     * @return void
     */
    protected function addDateTypeFilter(AbstractCollection $collection, $value, $field)
    {
        if (is_array($value) && count($value) == 2) {
            foreach (['from', 'to'] as $name) {
                $$name = array_shift($value);
                if (is_scalar($$name) && !empty($$name)) {
                    $date = (new \DateTime($$name))->format('m/d/Y');
                    $collection->addFieldToFilter($field, [$name => $date, 'date' => true]);
                }
            }
        }
    }

    /**
     * Add number type filter
     *
     * @param AbstractCollection $collection
     * @param mixed $value
     * @param string $field
     * @return void
     */
    protected function addNumberTypeFilter(AbstractCollection $collection, $value, $field)
    {
        if (is_array($value) && count($value) == 2) {
            foreach (['from', 'to'] as $name) {
                $$name = array_shift($value);
                if (is_numeric($$name)) {
                    $collection->addFieldToFilter($field, [$name => $$name]);
                }
            }
        }
    }

    /**
     * Retrieve entity type code
     *
     * @return string
     */
    public function getEntityTypeCode()
    {
        return 'directory_region';
    }

    /**
     * Retrieve header columns
     *
     * @return array
     */
    protected function _getHeaderColumns()
    {
        if (null === $this->headerColumns) {
            $this->headerColumns = array_merge(
                $this->_permanentAttributes,
                $this->_getExportAttributeCodes()
            );
        }
        return $this->headerColumns;
    }

    /**
     * Retrieve entity collection
     *
     * @return AbstractCollection
     */
    protected function _getEntityCollection()
    {
        $collection = $this->collectionFactory->create();
        $collection->addLabelsToResult();

        return $collection;
    }

    /**
     * Retrieve attribute collection
     *
     * @return \Magento\Framework\Data\Collection
     */
    public function getAttributeCollection()
    {
        $collection = parent::getAttributeCollection();
        $collection->setAtributesConfig($this->attributeConfig);

        return $collection;
    }
}
