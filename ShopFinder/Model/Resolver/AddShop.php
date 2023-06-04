<?php

namespace Chalhoub\ShopFinder\Model\Resolver;

use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Chalhoub\ShopFinder\Model\CreateShop;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Config\Element\Field;

class AddShop implements ResolverInterface
{
    /**
     * @var CreateShop
     */
    protected CreateShop $_createShop;

    /**
     * @param CreateShop $createShop
     */
    public function __construct(CreateShop $createShop)
    {
        $this->_createShop = $createShop;
    }

    /**
     * @inheritDoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (empty($args['input']) || !is_array($args['input'])) {
            throw new GraphQlInputException(__('"input" value should be specified'));
        }
        return ['shop' => $this->_createShop->persistData($args['input'])];
    }
}
