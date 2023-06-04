<?php

namespace Chalhoub\ShopFinder\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Chalhoub\ShopFinder\Model\UpdateShop;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;

class EditShop implements ResolverInterface
{
    /**
     * @var UpdateShop
     */
    protected UpdateShop $_updateShop;

    /**
     * @param UpdateShop $updateShop
     */
    public function __construct(UpdateShop $updateShop)
    {
        $this->_updateShop = $updateShop;
    }

    /**
     * @inheritDoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (empty($args['input']) || !is_array($args['input'])) {
            throw new GraphQlInputException(__('"input" value must be specified'));
        }
        if (empty($args['id'])) {
            throw new GraphQlInputException(__('Shop "id" value is a required value'));
        }
        $shop = $this->_updateShop->persistData($args['id'], $args['input']);
        return ['shop' => $shop];
    }
}
