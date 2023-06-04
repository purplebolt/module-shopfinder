<?php
/**
 * Copyright © 2023 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Chalhoub\ShopFinder\Model;

use Chalhoub\ShopFinder\Api\Data\ShopFinderInterface;
use Magento\Framework\Model\AbstractModel;

class ShopFinder extends AbstractModel implements ShopFinderInterface
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Chalhoub\ShopFinder\Model\ResourceModel\ShopFinder::class);
    }

    /**
     * @inheritDoc
     */
    public function getShopId()
    {
        return $this->getData(self::SHOP_ID);
    }

    /**
     * @inheritDoc
     */
    public function setShopId($shopId)
    {
        return $this->setData(self::SHOP_ID, $shopId);
    }

    /**
     * @inheritDoc
     */
    public function getShopName()
    {
        return $this->getData(self::SHOP_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setShopName($shopName)
    {
        return $this->setData(self::SHOP_NAME, $shopName);
    }

    /**
     * @inheritDoc
     */
    public function getIdentifier()
    {
        return $this->getData(self::IDENTIFIER);
    }

    /**
     * @inheritDoc
     */
    public function setIdentifier($identifier)
    {
        return $this->setData(self::IDENTIFIER, $identifier);
    }

    /**
     * @inheritDoc
     */
    public function getCountry()
    {
        return $this->getData(self::COUNTRY);
    }

    /**
     * @inheritDoc
     */
    public function setCountry($country)
    {
        return $this->setData(self::COUNTRY, $country);
    }

    /**
     * @inheritDoc
     */
    public function getShopImage()
    {
        return $this->getData(self::SHOP_IMAGE);
    }

    /**
     * @inheritDoc
     */
    public function setShopImage($shopImage)
    {
        return $this->setData(self::SHOP_IMAGE, $shopImage);
    }
}

