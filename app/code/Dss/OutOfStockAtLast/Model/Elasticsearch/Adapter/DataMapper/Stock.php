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
namespace Dss\OutOfStockAtLast\Model\Elasticsearch\Adapter\DataMapper;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Dss\OutOfStockAtLast\Model\ResourceModel\Inventory;

/**
 * Class Stock for mapping
 */
class Stock
{
    /**
     * Stock constructor.
     *
     * @param Inventory $inventory
     * @param StoreManagerInterface $storeManager
     * @noinspection PhpUnused
     */
    public function __construct(
        private Inventory $inventory,
        private StoreManagerInterface $storeManager
    ) {
    }

    /**
     * Map the attribute
     *
     * @param mixed $entityId
     * @param mixed $storeId
     * @return int[]
     * @throws NoSuchEntityException
     */
    public function map($entityId, $storeId): array
    {
        $sku = $this->inventory->getSkuRelation((int) $entityId);

        if (!$sku) {
            return ['out_of_stock_at_last' => 1];
        }

        $value = $this->inventory->getStockStatus(
            $sku,
            $this->storeManager->getStore($storeId)->getWebsite()->getCode()
        );

        return ['out_of_stock_at_last' => $value];
    }
}
