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
namespace Dss\OutOfStockAtLast\Model\Indexer\Stock;

use Magento\ConfigurableProduct\Model\ResourceModel\Indexer\Stock\Configurable as DefaultIndexer;
use Magento\Framework\DB\Select;

class Configurable extends DefaultIndexer
{
    /**
     * @inheritdoc
     */
    protected function _getStockStatusSelect($entityIds = null, $usePrimaryTable = false)
    {
        $select = parent::_getStockStatusSelect($entityIds, $usePrimaryTable);
        $this->_autoCalculate($select);

        return $select;
    }

    /**
     * Calculate depends on simple products
     *
     * @param Select $select
     * @throws \Zend_Db_Select_Exception
     */
    private function _autoCalculate($select)
    {
        $columns = $select->getPart(Select::COLUMNS);
        foreach ($columns as &$column) {
            if (isset($column[2]) && $column[2] == 'qty') {
                $column[1] = new \Zend_Db_Expr('SUM(IF(i.stock_status > 0, i.qty, 0))');
            }
        }
        $select->setPart(Select::COLUMNS, $columns);
    }
}
