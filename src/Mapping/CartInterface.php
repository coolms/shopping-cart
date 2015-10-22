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

use DateTime,
    CmsMoney\Mapping\CurrencyInterface,
    CmsMoney\Mapping\PriceableInterface;

/**
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
interface CartInterface extends ChangeableInterface, PriceableInterface, \Countable
{
    /**
     * @param string $number
     */
    public function setOrderNumber($number);

    /**
     * @return string
     */
    public function getOrderNumber();

    /**
     * @param DateTime $paidAt
     */
    public function setPaidAt(DateTime $paidAt);

    /**
     * @return DateTime
     */
    public function getPaidAt();

    /**
     * @param CurrencyInterface $currency
     * @return self
     */
    public function setCurrency(CurrencyInterface $currency);

    /**
     * @return CurrencyInterface
     */
    public function getCurrency();

    /**
     * @param ItemInterface[]|ItemProviderInterface[] $items
     * @return self
     */
    public function setItems($items);

    /**
     * @param ItemInterface[]|ItemProviderInterface[] $items
     * @return self
     */
    public function addItems($items);

    /**
     * @param ItemInterface|ItemProviderInterface $item
     * @return self
     */
    public function addItem($item);

    /**
     * @param ItemInterface[]|ItemProviderInterface[] $items
     * @return self
     */
    public function removeItems($items);

    /**
     * @param ItemInterface|ItemProviderInterface $item
     * @return self
     */
    public function removeItem($item);

    /**
     * Removes all items
     *
     * @return self
     */
    public function clearItems();

    /**
     * @param ItemInterface|ItemProviderInterface $item
     * @return bool
     */
    public function hasItem($item);

    /**
     * @return ItemInterface[]
     */
    public function getItems();

    /**
     * @return int
     */
    public function count();

    /**
     * @return int
     */
    public function getQuantity();

    /**
     * This refresh involves at least the recalculation
     * of all item prices in the cart
     *
     * @return self
     */
    public function refresh();
}
