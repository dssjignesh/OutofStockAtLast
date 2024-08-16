<?php

declare(strict_types=1);
/**
 * Digit Software Solutions.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 *
 * @category  Dss
 * @package   Dss_OutOfStockAtLast
 * @author    Extension Team
 * @copyright Copyright (c) 2024 Digit Software Solutions. ( https://digitsoftsol.com )
 */
namespace Dss\OutOfStockAtLast\Plugin\Model\Adapter;

/**
 * Class AdditionalFieldMapperPlugin for es attributes mapping
 */
class AdditionalFieldMapperPlugin
{
    /**
     * @var string[]
     */
    protected $allowedFields = [
        'out_of_stock_at_last' => 'integer'
    ];

    /**
     * Missing mapped attribute code
     *
     * @param mixed $subject
     * @param array $result
     * @return array
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetAllAttributesTypes($subject, array $result): array
    {
        foreach ($this->allowedFields as $fieldName => $fieldType) {
            $result[$fieldName] = ['type' => $fieldType];
        }

        return $result;
    }

    /**
     * 3rd module Compatibility
     *
     * @param mixed $subject
     * @param array $result
     * @return array
     */
    public function afterBuildEntityFields($subject, array $result): array
    {
        return $this->afterGetAllAttributesTypes($subject, $result);
    }
}
