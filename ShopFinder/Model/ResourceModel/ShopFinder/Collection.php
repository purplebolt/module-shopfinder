<?php
/**
 * Copyright © 2023 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Chalhoub\ShopFinder\Model\ResourceModel\ShopFinder;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'shop_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Chalhoub\ShopFinder\Model\ShopFinder::class,
            \Chalhoub\ShopFinder\Model\ResourceModel\ShopFinder::class
        );
    }
}

