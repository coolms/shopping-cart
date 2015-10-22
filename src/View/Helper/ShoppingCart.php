<?php
/**
 * CoolMS2 Shopping Cart Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/shopping-cart for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsShoppingCart\View\Helper;

use Zend\View\Helper\AbstractHelper,
    CmsShoppingCart\Service\ShoppingCartAwareTrait,
    CmsShoppingCart\Service\ShoppingCartInterface;

/**
 * View helper for shopping cart
 */
class ShoppingCart extends AbstractHelper
{
    use ShoppingCartAwareTrait;

    /**
     * __construct
     *
     * @param ShoppingCartInterface $shoppingCart
     */
    public function __construct(ShoppingCartInterface $shoppingCart)
    {
        $this->setShoppingCart($shoppingCart);
    }

    /**
     * @return ShoppingCartInterface
     */
    public function __invoke()
    {
        return $this->getShoppingCart();
    }

    /**
     * Proxy the shopping cart service
     *
     * @param  string $method
     * @param  array  $argv
     * @return mixed
     */
    public function __call($method, $argv)
    {
        return call_user_func_array([$this->getShoppingCart(), $method], $argv);
    }
}
