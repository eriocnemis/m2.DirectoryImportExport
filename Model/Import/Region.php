<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\Import;

use Magento\ImportExport\Model\Import;
use Magento\ImportExport\Model\Import\AbstractEntity;
use Eriocnemis\DirectoryImportExport\Model\Constant\Field;
use Eriocnemis\DirectoryImportExport\Model\Import\Validator\ValidatorPoolInterface;
use Eriocnemis\DirectoryImportExport\Model\Import\Handler\HandlerPoolInterface;

/**
 * Region import
 */
class Region extends AbstractEntity
{
    /**
     * Permanent entity columns
     *
     * @var string[]
     */
    protected $_permanentAttributes = [
        Field::COUNTRY_ID,
        Field::CODE
    ];

    /**
     * Code of a primary attribute of group
     *
     * @var string
     */
    protected $masterAttributeCode = Field::COUNTRY_ID;

    /**
     * List of available behaviors
     *
     * @var string[]
     */
    protected $_availableBehaviors = [
        Import::BEHAVIOR_APPEND,
        Import::BEHAVIOR_DELETE,
        Import::BEHAVIOR_REPLACE
    ];

    /**
     * Import validators pool
     *
     * @var ValidatorPoolInterface
     */
    protected $validatorPool;

    /**
     * Behavior validator
     *
     * @var Validator\ValidatorInterface
     */
    protected $validator;

    /**
     * Import handlers pool
     *
     * @var HandlerPoolInterface
     */
    protected $handlerPool;

    /**
     * Behavior handler
     *
     * @var Handler\HandlerInterface
     */
    protected $handler;

    /**
     * Initialize import
     *
     * @param Context $context
     * @param ValidatorPoolInterface $validatorPool
     * @param HandlerPoolInterface $handlerPool
     * @param array $data
     */
    public function __construct(
        Context $context,
        ValidatorPoolInterface $validatorPool,
        HandlerPoolInterface $handlerPool,
        array $data = []
    ) {
        $this->validatorPool = $validatorPool;
        $this->handlerPool = $handlerPool;

        parent::__construct(
            $context->getStringUtils(),
            $context->getScopeConfig(),
            $context->getImportFactory(),
            $context->getResourceHelper(),
            $context->getResource(),
            $context->getErrorAggregator(),
            $data
        );
    }

    /**
     * Import process start
     *
     * @return bool
     */
    public function importData()
    {
        $result = false;
        $this->_connection->beginTransaction();

        try {
            $result = $this->_importData();
            $this->_connection->commit();
        } catch (\Exception $e) {
            $this->_connection->rollBack();
        }

        return $result;
    }

    /**
     * Import data rows
     *
     * @return bool
     */
    protected function _importData()
    {
        while ($bunch = $this->_dataSourceModel->getNextBunch()) {
            foreach ($bunch as $rowNumber => $rowData) {
                if ($this->isRowAllowedToImport($rowData, (int)$rowNumber)) {
                    $this->getHandler()->execute($rowData);
                }
            }
        }
        return true;
    }

    /**
     * Imported entity type code getter
     *
     * @return string
     */
    public function getEntityTypeCode()
    {
        return 'directory_region';
    }

    /**
     * Retrieve true if row is valid and not in skipped rows array
     *
     * @param array $rowData
     * @param int $rowNumber
     * @return bool
     */
    public function isRowAllowedToImport(array $rowData, $rowNumber)
    {
        if ($this->getErrorAggregator()->hasToBeTerminated()) {
            $this->getErrorAggregator()->addRowToSkip($rowNumber);
        }

        return parent::isRowAllowedToImport($rowData, $rowNumber);
    }

    /**
     * Validate row data
     *
     * @param array $rowData
     * @param int $rowNumber
     * @return bool
     */
    public function validateRow(array $rowData, $rowNumber)
    {
        if (!isset($this->_validatedRows[$rowNumber])) {
            $errors = $this->getValidator()->validate($rowData);
            foreach ($errors as $error) {
                $this->addRowError($error, $rowNumber);
            }

            $this->_validatedRows[$rowNumber] = true;
            $this->_processedRowsCount++;
        }

        return !$this->getErrorAggregator()->isRowInvalid($rowNumber);
    }

    /**
     * Retrieve validator for specific behavior
     *
     * @return Validator\ValidatorInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function getValidator()
    {
        if (null === $this->validator) {
            $this->validator = $this->validatorPool->get($this->getBehavior());
        }
        return $this->validator;
    }

    /**
     * Retrieve handler for specific behavior
     *
     * @return Handler\HandlerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function getHandler()
    {
        if (null === $this->handler) {
            $this->handler = $this->handlerPool->get($this->getBehavior());
        }
        return $this->handler;
    }
}
