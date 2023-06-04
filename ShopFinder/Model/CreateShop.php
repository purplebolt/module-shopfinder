<?php

namespace Chalhoub\ShopFinder\Model;

use Magento\Framework\Exception\InvalidArgumentException;
use Magento\Framework\Exception\CouldNotSaveException;
use Chalhoub\ShopFinder\Api\ShopFinderRepositoryInterface;
use Chalhoub\ShopFinder\Api\Data\ShopFinderInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Chalhoub\ShopFinder\Api\Data\ShopFinderInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

class CreateShop
{

    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $_storeManager;
    /**
     * @var DataObjectHelper
     */
    protected DataObjectHelper $_dataObjectHelper;
    /**
     * @var ShopFinderInterfaceFactory
     */
    protected ShopFinderInterfaceFactory $_shopFinderFactory;
    /**
     * @var ShopFinderRepositoryInterface
     */
    protected ShopFinderRepositoryInterface $_shopFinderRepository;


    /**
     * @param DataObjectHelper $dataObjectHelper
     * @param ShopFinderInterface $shopFinderRepository
     * @param ShopFinderInterfaceFactory $shopFinderInterfaceFactory
     */
    public function __construct(
        DataObjectHelper $dataObjectHelper,
        ShopFinderRepositoryInterface $shopFinderRepository,
        ShopFinderInterfaceFactory $shopFinderInterfaceFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
        $this->_dataObjectHelper = $dataObjectHelper;
        $this->_shopFinderFactory = $shopFinderInterfaceFactory;
        $this->_shopFinderRepository = $shopFinderRepository;
    }

    /**
     * @param array $data
     * @return ShopFinderInterface
     * @throws GraphQlInputException
     * @throws InvalidArgumentException
     */
    public function persistData(array $data): ShopFinderInterface
    {
        try {
            $this->vaildate($data);
            $shop = $this->createShop($data);
        } catch (CouldNotSaveException $e) {
            throw new GraphQlInputException(__($e->getMessage()));
        }
        return $shop;
    }

    /**
     * Check to make sure required parameters are supplied
     * @param array $data
     * @throws InvalidArgumentException
     */
    protected function vaildate(array $data)
    {
        if (!isset($data[ShopFinderInterface::COUNTRY])) {
            throw new InvalidArgumentException(__('Country is a required field'));
        }
        if (!isset($data[ShopFinderInterface::IDENTIFIER])) {
            throw new InvalidArgumentException(__('Identifier is a required field'));
        }
        if (!isset($data[ShopFinderInterface::SHOP_NAME])) {
            throw new InvalidArgumentException(__('Name is a required field'));
        }
    }

    /**
     * @param array $data
     * @return ShopFinderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function createShop(array $data): ShopFinderInterface
    {
        try {
            $mediaUrl = $this->_storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
            $mediaUrl.='shopImages/images/';
            /** @var ShopFinderInterface $shopDataObject */
            $shopDataObject = $this->_shopFinderFactory->create();
            $shopDataObject->load($data["identifier"], "identifier");

            if($shopDataObject->getShopId()) {
                $shopDataObject->setShopName($data["shop_name"]);
                $shopDataObject->setCountry($data["country"]);
                $shopDataObject->setShopImage($data["shop_image"]);
            } else {
                $this->_dataObjectHelper->populateWithArray(
                    $shopDataObject,
                    $data,
                    ShopFinderInterface::class
                );
            }
            $this->_shopFinderRepository->save($shopDataObject);
            $shopDataObject->setShopImage($mediaUrl.$shopDataObject->getShopImage());
            return $shopDataObject;
        } catch (CouldNotSaveException $e) {
            throw new GraphQlInputException(__($e->getMessage()));
        }
    }
}
