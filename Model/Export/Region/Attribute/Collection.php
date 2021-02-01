<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\Export\Region\Attribute;

use Magento\Framework\DataObject;
use Magento\Framework\Data\Collection as AbstractCollection;
use Magento\Eav\Model\Entity\Attribute;

/**
 * Attribute collection
 */
class Collection extends AbstractCollection
{
    /**
     * Item object class name
     *
     * @var string
     */
    protected $_itemObjectClass = Attribute::class;

    /**
     * Attribute config
     *
     * @var mixed[]
     */
    private $attributeConfig = [];

    /**
     * Set atributes config
     *
     * @param mixed[] $attributeConfig
     * @return $this
     */
    public function setAtributesConfig(array $attributeConfig)
    {
        $this->attributeConfig = $attributeConfig;
        return $this;
    }

    /**
     * Add field filter to collection
     *
     * @param string|array $field
     * @param string|int|array $condition
     * @return $this
     */
    public function addFieldToFilter($field, $condition)
    {
        if (isset($condition['like'])) {
            $regex = $this->_prepareLikeValue($condition['like']);
            $this->addCallbackFilter($field, $regex, 'filterLike');
        }
        return $this;
    }

    /**
     * Load data
     *
     * @param bool $printQuery
     * @param bool $logQuery
     * @return $this
     */
    public function loadData($printQuery = false, $logQuery = false)
    {
        $id = 0;
        foreach ($this->attributeConfig as $code => $data) {
            $data['attribute_id'] = $id++;
            $data['attribute_code'] = $code;
            $item = $this->getNewEmptyItem();
            $item->addData($data);
            $this->addItem($item);
        }

        $this->_renderFilters();
        $this->_renderOrders();

        return $this->_setIsLoaded();
    }

    /**
     * Load data
     *
     * @param bool $printQuery
     * @param bool $logQuery
     * @return $this
     */
    public function load($printQuery = false, $logQuery = false)
    {
        if (!$this->isLoaded()) {
            return $this->loadData($printQuery, $logQuery);
        }
        return $this;
    }

    /**
     * Render conditions
     *
     * @return $this
     */
    protected function _renderFilters()
    {
        if (!$this->_isFiltersRendered) {
            foreach ($this->_items as $key => $item) {
                foreach ($this->_filters as $filter) {
                    if (!call_user_func_array([$this, $filter->getCallback()], [$item, $filter])) {
                        unset($this->_items[$key]);
                    }
                }
            }
        }
        return $this;
    }

    /**
     * Render orders
     *
     * @return $this
     */
    protected function _renderOrders()
    {
        if ($this->_orders) {
            uasort($this->_items, [$this, 'compareAttributes']);
        }
        return $this;
    }

    /**
     * Compare two collection items
     *
     * @param DataObject $a
     * @param DataObject $b
     * @return int
     */
    public function compareAttributes(DataObject $a, DataObject $b)
    {
        foreach ($this->_orders as $field => $direction) {
            $result = strnatcmp($a->getData($field), $b->getData($field));
            return self::SORT_ORDER_ASC === strtoupper($direction) ? $result : -$result;
            break;
        }
    }

    /**
     * Add callback collection filter
     *
     * @param string $field
     * @param string $value
     * @param string $callback
     * @return $this
     */
    public function addCallbackFilter($field, $value, $callback)
    {
        $filter = new DataObject();
        $filter['field'] = $field;
        $filter['value'] = $value;
        $filter['callback'] = $callback;

        $this->_filters[] = $filter;
        $this->_isFiltersRendered = false;
        return $this;
    }

    /**
     * Callback method for like fancy filter
     *
     * @param Attribute $item
     * @param DataObject $filter
     * @return bool
     */
    public function filterLike($item, $filter)
    {
        $regex = $filter->getValue();
        $field = $filter->getField();
        return (bool)preg_match("/^{$regex}\$/i", $item->getData($field));
    }

    /**
     * Prepare Like filter value
     *
     * @param string $value
     * @return string
     */
    protected function _prepareLikeValue($value)
    {
        $value = trim(stripslashes($value), '\'');
        $value = trim($value, '%');
        return '(.*?)' . preg_quote($value, '/') . '(.*?)';
    }
}
 
