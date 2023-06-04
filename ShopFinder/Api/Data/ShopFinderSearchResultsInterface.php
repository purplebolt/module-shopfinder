<?php
/**
 * Copyright © 2023 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Chalhoub\ShopFinder\Api\Data;

interface ShopFinderSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get ShopFinder list.
     * @return \Chalhoub\ShopFinder\Api\Data\ShopFinderInterface[]
     */
    public function getItems();

    /**
     * Set shop_name list.
     * @param \Chalhoub\ShopFinder\Api\Data\ShopFinderInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

