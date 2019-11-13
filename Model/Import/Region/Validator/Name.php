<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\Import\Region\Validator;

use Magento\Framework\Stdlib\StringUtils;
use Eriocnemis\DirectoryImportExport\Model\Constant\Field;
use Eriocnemis\DirectoryImportExport\Model\Import\Validator\ValidatorInterface;

/**
 * Region name validator
 */
class Name implements ValidatorInterface
{
    /**
     * Max DB field length
     */
    const DB_MAX_LENGTH = 255;

    /**
     * Magento string lib
     *
     * @var StringUtils
     */
    protected $string;

    /**
     * Initialize validator
     *
     * @param StringUtils $string
     */
    public function __construct(
        StringUtils $string
    ) {
        $this->string = $string;
    }

    /**
     * Validate data row
     *
     * @param array $rowData
     * @return array
     */
    public function validate(array $rowData)
    {
        $errors = [];
        $errors += $this->validateEmpty($rowData[Field::NAME]);
        $errors += $this->validateLength($rowData[Field::NAME]);

        return $errors;
    }

    /**
     * Check whether name is empty
     *
     * @param string $name
     * @return array
     */
    protected function validateEmpty($name)
    {
        if (!\Zend_Validate::is($name, 'NotEmpty')) {
            return [
                __('Region name field is empty.')
            ];
        }
        return [];
    }

    /**
     * Check whether name is correct size
     *
     * @param string $name
     * @return array
     */
    protected function validateLength($name)
    {
        if ($this->string->strlen($name) > self::DB_MAX_LENGTH) {
            return [
                __('Region name exceeded max length.')
            ];
        }
        return [];
    }
}
