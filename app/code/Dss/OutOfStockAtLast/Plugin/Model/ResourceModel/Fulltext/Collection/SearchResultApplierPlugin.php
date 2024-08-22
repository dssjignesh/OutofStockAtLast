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
namespace Dss\OutOfStockAtLast\Plugin\Model\ResourceModel\Fulltext\Collection;

use Dss\OutOfStockAtLast\Model\Elasticsearch\Flag;
use Magento\Elasticsearch\Model\ResourceModel\Fulltext\Collection\SearchResultApplier;

/**
 * Class SearchResultApplierPlugin marking apply flag
 */
class SearchResultApplierPlugin
{
    /**
     * @param Flag $flag
     */
    public function __construct(
        private Flag $flag
    ) {
    }

    /**
     * Mark start and stop for flag
     *
     * @param SearchResultApplier $subject
     * @param callable $proceed
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundApply(SearchResultApplier $subject, callable $proceed): void
    {
        $this->flag->apply();
        $proceed();
        $this->flag->stop();
    }
}
