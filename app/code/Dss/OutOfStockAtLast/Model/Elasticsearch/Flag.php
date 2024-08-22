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
namespace Dss\OutOfStockAtLast\Model\Elasticsearch;

/**
 * Class Flag for determine and ignore Using Price indexing
 */
class Flag
{
    /**
     * @var bool
     */
    private $isApplied = false;

    /**
     * Apply flag
     *
     * @return void
     */
    public function apply(): void
    {
        $this->isApplied = true;
    }

    /**
     * Stop applying flag
     *
     * @return void
     */
    public function stop(): void
    {
        $this->isApplied = false;
    }

    /**
     * Determine flag
     *
     * @return bool
     */
    public function isApplied(): bool
    {
        return $this->isApplied;
    }
}
