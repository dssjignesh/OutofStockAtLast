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
namespace Dss\OutOfStockAtLast\Plugin\Model\Adapter\BatchDataMapper;

use Dss\OutOfStockAtLast\Model\Elasticsearch\Adapter\DataMapper\Stock as StockDataMapper;
use Dss\OutOfStockAtLast\Model\ResourceModel\Inventory;
use Magento\Elasticsearch\Model\Adapter\BatchDataMapper\ProductDataMapper;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class ProductDataMapperPlugin for mapping hook
 */
class ProductDataMapperPlugin
{
    /**
     * ProductDataMapperPlugin constructor.
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
     * Map more attributes
     *
     * @param ProductDataMapper $subject
     * @param mixed $documents
     * @param mixed $documentData
     * @param mixed $storeId
     * @param mixed $context
     * @return mixed
     * @throws NoSuchEntityException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterMap(
        ProductDataMapper $subject,
        mixed $documents,
        mixed $documentData,
        mixed $storeId,
        mixed $context
    ): mixed {
        $this->inventory->saveRelation(array_keys($documents));

        foreach ($documents as $productId => $document) {
            //phpcs:ignore Magento2.Performance.ForeachArrayMerge.ForeachArrayMerge
            $document = array_merge($document, $this->stockDataMapper->map($productId, $storeId));
            $documents[$productId] = $document;
        }

        $this->inventory->clearRelation();

        return $documents;
    }
}
