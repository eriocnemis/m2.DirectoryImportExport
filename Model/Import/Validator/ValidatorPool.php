<?php
/**
 * Copyright © Eriocnemis, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Eriocnemis\DirectoryImportExport\Model\Import\Validator;

use Magento\Framework\Exception\LocalizedException;

/**
 * Behavior validator pool
 */
class ValidatorPool implements ValidatorPoolInterface
{
    /**
     * Behavior validators
     *
     * @var ValidatorInterface[]
     */
    protected $validators = [];

    /**
     * Initialize pool
     *
     * @param ValidatorInterface[] $validators
     */
    public function __construct(
        $validators = []
    ) {
        foreach ($validators as $validator) {
            if (!$validator instanceof ValidatorInterface) {
                throw new LocalizedException(
                    __('Behavior validator must implement %1.', ValidatorInterface::class)
                );
            }
        }
        $this->validators = $validators;
    }

    /**
     * Retrieve validator for specific behavior
     *
     * @param string $behavior
     * @return ValidatorInterface
     * @throws LocalizedException
     */
    public function get($behavior)
    {
        if (!isset($this->validators[$behavior])) {
            throw new LocalizedException(
                __('There is no validator registered for behavior %1.', $behavior)
            );
        }
        return $this->validators[$behavior];
    }
}
