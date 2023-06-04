<?php
/**
 * Copyright © 2023 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Chalhoub\ShopFinder\Api\Data;

interface ShopFinderInterface
{

    const IDENTIFIER = 'identifier';
    const COUNTRY = 'country';
    const SHOP_ID = 'shop_id';
    const SHOPIMAGE = 'shopImage';
    const SHOP_NAME = 'shop_name';

    /**
     * Get shop_id
     * @return string|null
     */
    public function getShopId();

    /**
     * Set shop_id
     * @param string $shopId
     * @return \Chalhoub\ShopFinder\ShopFinder\Api\Data\ShopFinderInterface
     */
    public function setShopId($shopId);

    /**
     * Get shop_name
     * @return string|null
     */
    public function getShopName();

    /**
     * Set shop_name
     * @param string $shopName
     * @return \Chalhoub\ShopFinder\ShopFinder\Api\Data\ShopFinderInterface
     */
    public function setShopName($shopName);

    /**
     * Get identifier
     * @return string|null
     */
    public function getIdentifier();

    /**
     * Set identifier
     * @param string $identifier
     * @return \Chalhoub\ShopFinder\ShopFinder\Api\Data\ShopFinderInterface
     */
    public function setIdentifier($identifier);

    /**
     * Get country
     * @return string|null
     */
    public function getCountry();

    /**
     * Set country
     * @param string $country
     * @return \Chalhoub\ShopFinder\ShopFinder\Api\Data\ShopFinderInterface
     */
    public function setCountry($country);

    /**
     * Get shopImage
     * @return string|null
     */
    public function getShopImage();

    /**
     * Set shopImage
     * @param string $shopImage
     * @return \Chalhoub\ShopFinder\ShopFinder\Api\Data\ShopFinderInterface
     */
    public function setShopImage($shopImage);
}

