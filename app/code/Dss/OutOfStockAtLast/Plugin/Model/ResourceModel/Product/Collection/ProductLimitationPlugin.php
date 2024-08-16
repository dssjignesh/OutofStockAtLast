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
namespace Dss\OutOfStockAtLast\Plugin\Model\ResourceModel\Product\Collection;

use Dss\OutOfStockAtLast\Model\Elasticsearch\Flag;
use Magento\Catalog\Model\ResourceModel\Product\Collection\ProductLimitation;

/**
 * Class ProductLimitationPlugin ignoring Using Price indexing also @see MC-42243
 */
class ProductLimitationPlugin
{
    /**
     * @param Flag $flag
     * @noinspection PhpUnused
     */
    public function __construct(private Flag $flag)
    {
    }

    /**
     * Ignore using price indexing @see Issue#10
     *
     * @param ProductLimitation $subject
     * @param bool $result
     * @return bool
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterIsUsingPriceIndex(ProductLimitation $subject, bool $result): bool
    {
        if ($this->flag->isApplied()) {
            $result = false;
        }

        return $result;
    }
}
