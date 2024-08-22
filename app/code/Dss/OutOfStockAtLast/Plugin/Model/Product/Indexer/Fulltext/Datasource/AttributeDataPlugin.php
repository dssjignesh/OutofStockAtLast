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
namespace Dss\OutOfStockAtLast\Plugin\Model\Product\Indexer\Fulltext\Datasource;

use Dss\OutOfStockAtLast\Model\Elasticsearch\Adapter\DataMapper\Stock as StockDataMapper;
use Dss\OutOfStockAtLast\Model\ResourceModel\Inventory;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class AttributeDataPlugin for fulltext datasource mapping
 */
class AttributeDataPlugin
{
    /**
     * AttributeDataPlugin constructor.
     *
     * @param StockDataMapper $stockDataMapper
     * @param Inventory $inventory
     */
    public function __construct(
        protected StockDataMapper $stockDataMapper,
        protected Inventory $inventory
    ) {
    }

    /**
     * Add data for datasource
     *
     * @param mixed $subject
     * @param array $result
     * @param mixed $storeId
     * @param array $indexData
     * @return array
     * @throws NoSuchEntityException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterAddData(
        mixed $subject,
        array $result,
        mixed $storeId,
        array $indexData
    ): array {
        $this->inventory->saveRelation(array_keys($indexData));
        // Use a temporary array to hold the updated results
        $updatedResults = [];
        foreach ($result as $productId => $item) {
            $mappedData = $this->stockDataMapper->map($productId, $storeId);
            // Manually merge arrays without using array_merge
            $updatedResults[$productId] = $item + $mappedData;
        }
        $this->inventory->clearRelation();

        return $updatedResults;
    }
}
