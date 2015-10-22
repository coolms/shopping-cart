<?php
/**
 * CoolMS2 Shopping Cart Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/shopping-cart for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsShoppingCart\Mapping;

use CmsCommon\Mapping\Common\DescribableInterface,
    CmsCommon\Mapping\Common\NameableInterface,
    CmsCommon\Mapping\Common\ObjectableInterface,
    CmsCommon\Mapping\Common\QuantifiableInterface,
    CmsMoney\Mapping\Money;

/**
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
interface ItemInterface extends
    ChangeableInterface,
    DescribableInterface,
    NameableInterface,
    ObjectableInterface,
    QuantifiableInterface
{
    /**
     * @param CartInterface $cart
     * @return self
     */
    public function setCart(CartInterface $cart);

    /**
     * @return CartInterface
     */
    public function getCart();

    /**
     * @return Money
     */
    public function getPrice();

    /**
     * @param ItemInterface $item
     * @return bool
     */
    public function equals(ItemInterface $item);

    /**
     * @param ItemInterface $item
     * @return self
     */
    public function add(ItemInterface $item);

    /**
     * @param ItemInterface $item
     * @return self
     */
    public function subtract(ItemInterface $item);
}
