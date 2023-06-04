<?php
/**
 * Copyright © 2023 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Chalhoub\ShopFinder\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface ShopFinderRepositoryInterface
{

    /**
     * Save ShopFinder
     * @param \Chalhoub\ShopFinder\Api\Data\ShopFinderInterface $shopFinder
     * @return \Chalhoub\ShopFinder\Api\Data\ShopFinderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Chalhoub\ShopFinder\Api\Data\ShopFinderInterface $shopFinder
    );

    /**
     * Retrieve ShopFinder
     * @param string $shopfinderId
     * @return \Chalhoub\ShopFinder\Api\Data\ShopFinderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($shopfinderId);

    /**
     * Retrieve ShopFinder matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Chalhoub\ShopFinder\Api\Data\ShopFinderSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Shop
     * @param \Chalhoub\ShopFinder\Api\Data\ShopFinderInterface $shopFinder
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Chalhoub\ShopFinder\Api\Data\ShopFinderInterface $shopFinder
    );

    /**
     * Delete Shop by ID
     * @param string $shopfinderId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($shopfinderId);
}

