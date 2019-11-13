<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\Import\Validator;

use Magento\Framework\Exception\LocalizedException;

/**
 * Behavior composite validator
 */
class CompositeValidator implements ValidatorInterface
{
    /**
     * Entity validators
     *
     * @var ValidatorInterface[]
     */
    protected $validators = [];

    /**
     * Initialize validator
     *
     * @param ValidatorInterface[] $validators
     */
    public function __construct(
        array $validators = []
    ) {
        foreach ($validators as $validator) {
            if (!$validator instanceof ValidatorInterface) {
                throw new LocalizedException(
                    __('Validator must implement %1.', ValidatorInterface::class)
                );
            }
        }
        $this->validators = $validators;
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
        foreach ($this->validators as $validator) {
            $errors += $validator->validate($rowData);
        }
        return $errors;
    }
}
