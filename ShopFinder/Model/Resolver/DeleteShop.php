<?php

namespace Chalhoub\ShopFinder\Model\Resolver;

use Magento\Framework\GraphQl\Exception\GraphQlAuthorizationException;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;

class DeleteShop implements ResolverInterface
{

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null) {
        throw new GraphQlAuthorizationException(__('The current user isnt authorized to delete a shop'));
    }
}
