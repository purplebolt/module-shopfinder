<?php
/**
 * Copyright © 2023 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Chalhoub\ShopFinder\Model\ShopFinder;
use Chalhoub\ShopFinder\Model\ResourceModel\ShopFinder\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Chalhoub\ShopFinder\Model\ResourceModel\ShopFinder\Collection;

class DataProvider extends AbstractDataProvider
{

    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $_storeManager;

    /**
     * @var DataPersistorInterface
     */
    protected DataPersistorInterface $_dataPersistor;

    protected  $collection;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param StoreManagerInterface $storeManager
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->_storeManager = $storeManager;
        $this->_dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        /** @var Collection $items */
        $items = $this->collection->getItems();

        foreach ($items as $model) {
            $this->loadedData[$model->getshopId()] = $model->getData();
            $image = [];
            if ($model->getShopId()) {
                $image[0]['name'] = $model->getShopImage();
                $image[0]['url'] = $this->getMediaDir().$model->getShopImage();
                $this->loadedData[$model->getId()]['shopImage'] = $image;
            }
        }
        $data = $this->_dataPersistor->get('chalhoub_shopfinder');
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->_dataPersistor->clear('chalhoub_shopfinder');
        }
        return $this->loadedData;
    }

    public function getMediaDir():string
    {
        return $this->_storeManager->getStore()
                ->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ).'shopImages/images/';

    }
}
