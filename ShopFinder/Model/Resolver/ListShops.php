<?php

namespace Chalhoub\ShopFinder\Model\Resolver;

use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\Argument\SearchCriteria\Builder as SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Chalhoub\ShopFinder\Api\ShopFinderRepositoryInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use  Magento\Store\Model\StoreManagerInterface;

class ListShops implements ResolverInterface
{
    /**
     * @var ShopFinderRepositoryInterface
     */
    protected ShopFinderRepositoryInterface $_shopFinderRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    protected SearchCriteriaBuilder $_searchCriteriaBuilder;
    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $_storeManager;

    /**
     * @param ShopFinderRepositoryInterface $shopFinderRepository
     * @param StoreManagerInterface $storeManager
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        ShopFinderRepositoryInterface $shopFinderRepository,
        StoreManagerInterface $storeManager,
        SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        $this->_shopFinderRepository = $shopFinderRepository;
        $this->_storeManager = $storeManager;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param array $args
     * @throws GraphQlInputException
     */
    private function validateInput(array $args): void
    {
        if (isset($args['pageSize']) && $args['pageSize'] <= 0) {
            throw new GraphQlInputException(__('pageSize value must cant be 0.'));
        }
        if (isset($args['currentPage']) && $args['currentPage'] <= 0) {
            throw new GraphQlInputException(__('currentPage value has to be greater than 0.'));
        }
    }

    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {

        $this->validateInput($args);
        $searchCriteria = $this->_searchCriteriaBuilder->build('shopFinderFilterAttr', $args);
        $searchCriteria->setCurrentPage($args['currentPage']);
        $searchCriteria->setPageSize($args['pageSize']);
        $searchResult = $this->_shopFinderRepository->getList($searchCriteria);
        $mediaUrl = $this->_storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $mediaUrl.='shopImages/images/';
        foreach ($searchResult->getItems() as $item) {
            $item->setShopImage($mediaUrl.$item->getShopImage());
        }
        return [
            'total_count' => $searchResult->getTotalCount(),
            'items' => $searchResult->getItems(),
        ];
    }
}
