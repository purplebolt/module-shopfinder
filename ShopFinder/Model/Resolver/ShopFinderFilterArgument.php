<?php

namespace Chalhoub\ShopFinder\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\ConfigInterface;
use Magento\Framework\GraphQl\Query\Resolver\Argument\FieldEntityAttributesInterface;

class ShopFinderFilterArgument implements FieldEntityAttributesInterface
{
    /** @var ConfigInterface */
    protected $_config;

    public function __construct(ConfigInterface $config)
    {
        $this->_config = $config;
    }

    public function getEntityAttributes(): array
    {
        $fields = [];
        /** @var Field $field */

        foreach ($this->_config->getConfigElement('ShopFinder')->getFields() as $field) {

            $fields[$field->getName()] = [
                'type' => 'String',
                'fieldName' => $field->getName(),
            ];
        }
        return $fields;
    }
}
