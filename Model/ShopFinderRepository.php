<?php
/**
 * Copyright © 2023 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Chalhoub\ShopFinder\Model;

use Chalhoub\ShopFinder\Api\Data\ShopFinderInterface;
use Chalhoub\ShopFinder\Api\Data\ShopFinderInterfaceFactory;
use Chalhoub\ShopFinder\Api\Data\ShopFinderSearchResultsInterfaceFactory;
use Chalhoub\ShopFinder\Api\ShopFinderRepositoryInterface;
use Chalhoub\ShopFinder\Model\ResourceModel\ShopFinder as ResourceShopFinder;
use Chalhoub\ShopFinder\Model\ResourceModel\ShopFinder\CollectionFactory as ShopFinderCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class ShopFinderRepository implements ShopFinderRepositoryInterface
{

    /**
     * @var ShopFinderInterfaceFactory
     */
    protected $shopFinderFactory;

    /**
     * @var ResourceShopFinder
     */
    protected $resource;

    /**
     * @var ShopFinderCollectionFactory
     */
    protected $shopFinderCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var ShopFinder
     */
    protected $searchResultsFactory;


    /**
     * @param ResourceShopFinder $resource
     * @param ShopFinderInterfaceFactory $shopFinderFactory
     * @param ShopFinderCollectionFactory $shopFinderCollectionFactory
     * @param ShopFinderSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceShopFinder $resource,
        ShopFinderInterfaceFactory $shopFinderFactory,
        ShopFinderCollectionFactory $shopFinderCollectionFactory,
        ShopFinderSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->shopFinderFactory = $shopFinderFactory;
        $this->shopFinderCollectionFactory = $shopFinderCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(ShopFinderInterface $shopFinder)
    {
        try {
            $this->resource->save($shopFinder);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the shop: %1',
                $exception->getMessage()
            ));
        }
        return $shopFinder;
    }

    /**
     * @inheritDoc
     */
    public function get($shopFinderId)
    {
        $shopFinder = $this->shopFinderFactory->create();
        $this->resource->load($shopFinder, $shopFinderId);
        if (!$shopFinder->getId()) {
            throw new NoSuchEntityException(__('Shop with id "%1" does not exist.', $shopFinderId));
        }
        return $shopFinder;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->shopFinderCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(ShopFinderInterface $shopFinder)
    {
        try {
            $shopFinderModel = $this->shopFinderFactory->create();
            $this->resource->load($shopFinderModel, $shopFinder->getShopfinderId());
            $this->resource->delete($shopFinderModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the ShopFinder: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($shopFinderId)
    {
        return $this->delete($this->get($shopFinderId));
    }
}

