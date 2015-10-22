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

use CmsCommon\Mapping\Common\NameableInterface,
    CmsCommon\Mapping\Common\DescribableInterface,
    CmsCommon\Mapping\Common\ValuableInterface;

/**
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
interface StatusInterface extends ValuableInterface, NameableInterface, DescribableInterface
{
    const STATUS_INITIALIZED = 'initialized';
    const STATUS_PENDING     = 'pending';
    const STATUS_CONFIRMED   = 'confirmed';
    const STATUS_CANCELED    = 'canceled';
    const STATUS_REFUNDED    = 'refunded';
    const STATUS_SHIPPED     = 'shipped';

    /**
     * @param int $code
     * @return self
     */
    public function setCode($code);

    /**
     * @return int
     */
    public function getCode();

    /**
     * @param StatusInterface $status
     * @return bool
     */
    public function isChangeable(StatusInterface $status);

    /**
     * @param string|StatusInterface $status
     * @return bool
     */
    public function equals($status);

    /**
     * @param ItemInterface $item
     */
    public function visit(ItemInterface $item);
}
