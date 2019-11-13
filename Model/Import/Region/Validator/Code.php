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
 * Region code validator
 */
class Code implements ValidatorInterface
{
    /**
     * Max DB field length
     */
    const DB_MAX_LENGTH = 32;

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
        $errors += $this->validateEmpty($rowData[Field::CODE]);
        $errors += $this->validateLength($rowData[Field::CODE]);

        return $errors;
    }

    /**
     * Check whether code is empty
     *
     * @param string $code
     * @return array
     */
    protected function validateEmpty($code)
    {
        if (!\Zend_Validate::is($code, 'NotEmpty')) {
            return [
                __('Region code field is empty.')
            ];
        }
        return [];
    }

    /**
     * Check whether code is correct size
     *
     * @param string $code
     * @return array
     */
    protected function validateLength($code)
    {
        if ($this->string->strlen($code) > self::DB_MAX_LENGTH) {
            return [
                __('Region code exceeded max length.')
            ];
        }
        return [];
    }
}
