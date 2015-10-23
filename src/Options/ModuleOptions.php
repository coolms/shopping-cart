<?php 
/**
 * CoolMS2 Shopping Cart Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/shopping-cart for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsShoppingCart\Options;

use Zend\Stdlib\AbstractOptions,
    CmsMoney\Service\CurrencyListInterface,
    CmsShoppingCart\Mapping\CartInterface;

class ModuleOptions extends AbstractOptions implements ModuleOptionsInterface
{
    /**
     * Turn off strict options mode
     *
     * @var bool
     */
    protected $__strictMode__ = false;

    /**
     * @var string
     */
    protected $shoppingCartClass = CartInterface::class;

    /**
     * @var string
     */
    protected $currencyListClass = CurrencyListInterface::class;

    /**
     * {@inheritDoc}
     */
    public function getShoppingCartClass()
    {
        return $this->shoppingCartClass;
    }

    /**
     * @param string $class
     * @return self
    */
    public function setShoppingCartClass($class)
    {
        $this->shoppingCartClass = (string) $class;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrencyListClass()
    {
        return $this->currencyListClass;
    }

    /**
     * @param string $class
     * @return self
     */
    public function setCurrencyListClass($class)
    {
        $this->currencyListClass = (string) $class;
        return $this;
    }
}
