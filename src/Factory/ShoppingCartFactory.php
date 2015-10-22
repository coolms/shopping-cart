<?php
/**
 * CoolMS2 Shopping Cart Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/shopping-cart for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsShoppingCart\Factory;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsShoppingCart\Options\ModuleOptionsInterface,
    CmsShoppingCart\Options\ModuleOptions,
    CmsShoppingCart\Service\ShoppingCart,
    CmsShoppingCart\Service\ShoppingCartInterface;

class ShoppingCartFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return ShoppingCartInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $options ModuleOptionsInterface */
        $options = $serviceLocator->get(ModuleOptions::class);
        return new ShoppingCart($options, $serviceLocator);
    }
}
