<?php

namespace Chalhoub\ShopFinder\Model;

use Chalhoub\ShopFinder\Api\ShopFinderRepositoryInterface;
use Chalhoub\ShopFinder\Api\Data\ShopFinderInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Api\DataObjectHelper;
use  Magento\Store\Model\StoreManagerInterface;
use Chalhoub\ShopFinder\Api\Data\ShopFinderInterfaceFactory;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;

class UpdateShop
{

    /**
     * @var DataObjectHelper
     */
    protected DataObjectHelper $_dataObjectHelper;
    /**
     * @var ShopFinderInterface
     */
    protected ShopFinderRepositoryInterface $_shopFinderRepository;
    /**
     * @var ShopFinderInterface
     */
    protected ShopFinderInterfaceFactory $_shopFinderFactory;
    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $_storeManager;

    /**
     * @param ShopFinderRepositoryInterface $shopFinderRepository
     * @param StoreManagerInterface $storeManager
     * @param DataObjectHelper $dataObjectHelper
     * @param ShopFinderInterfaceFactory $shopFinderInterfaceFactory
     */
    public function __construct(
        ShopFinderRepositoryInterface $shopFinderRepository,
        StoreManagerInterface $storeManager,
        DataObjectHelper $dataObjectHelper,
        ShopFinderInterfaceFactory $shopFinderInterfaceFactory
    ) {
        $this->_shopFinderRepository = $shopFinderRepository;
        $this->_storeManager = $storeManager;
        $this->_dataObjectHelper = $dataObjectHelper;
        $this->_shopFinderFactory = $shopFinderInterfaceFactory;
    }

    /**
     * @param int $id
     * @param array $data
     * @return ShopFinderInterface
     * @throws GraphQlInputException
     */
    public function persistData(int $id, array $data): ShopFinderInterface
    {
        try {
            $shop = $this->updateShop($id, $data);
        } catch (CouldNotSaveException $e) {
            throw new GraphQlInputException(__($e->getMessage()));
        } catch (LocalizedException $e) {
            throw new GraphQlInputException(__($e->getMessage()));
        }
        return $shop;
    }


    /**
     * @param int $id
     * @param array $data
     * @return ShopFinderInterface
     * @throws LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function updateShop(int $id, array $data): ShopFinderInterface
    {
        $mediaUrl = $this->_storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $mediaUrl.='shopImages/images/';

        /** @var ShopFinderInterface $shopFinderDataObject */
        $shopDataObject = $this->_shopFinderFactory->create();
        $shopDataObject->load($id, ShopFinderInterface::SHOP_ID);

        if(!$shopDataObject->getShopId()) {
            throw new LocalizedException(__('Shop ID is a required field'));
        }
        if (isset($data[ShopFinderInterface::SHOP_NAME])) {
            $shopDataObject->setShopName($data[ShopFinderInterface::SHOP_NAME]);
        }
        if (isset($data[ShopFinderInterface::COUNTRY])) {
            $shopDataObject->setCountry($data[ShopFinderInterface::COUNTRY]);
        }
        if (isset($data[ShopFinderInterface::SHOPIMAGE])) {
            $shopDataObject->setImage($data[ShopFinderInterface::SHOPIMAGE]);
        }
        if (isset($data[ShopFinderInterface::SHOP_NAME])) {
            $shopDataObject->setIdentifier($data[ShopFinderInterface::IDENTIFIER]);
        }
        $this->_shopFinderRepository->save($shopDataObject);
        $shopDataObject->setImage($mediaUrl.$shopDataObject->getImage());
        return $shopDataObject;
    }
}
