<?php
/**
 * CoolMS2 Shopping Cart Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/shopping-cart for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsShoppingCart\Factory\View\Helper;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\View\Helper\AbstractHelper,
    CmsShoppingCart\Service\ShoppingCartInterface,
    CmsShoppingCart\View\Helper\ShoppingCart;

class ShoppingCartHelperFactory extends AbstractHelper implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return ShoppingCart
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services = $serviceLocator->getServiceLocator();
        return new ShoppingCart($services->get(ShoppingCartInterface::class));
    }
}
