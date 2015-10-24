<?php
/**
 * CoolMS2 Shopping Cart Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/shopping-cart for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsShoppingCart\Service;

use ArrayIterator,
    Iterator,
    Zend\ServiceManager\ServiceLocatorAwareTrait,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsCommon\Service\DomainServiceInterface,
    CmsCommon\Service\DomainServiceProviderTrait,
    CmsCommon\Stdlib\OptionsProviderTrait,
    CmsMoney\Money,
    CmsMoney\Service\CurrencyListAwareTrait,
    CmsMoney\Service\CurrencyListInterface,
    CmsShoppingCart\Mapping\CartInterface,
    CmsShoppingCart\Mapping\ItemInterface,
    CmsShoppingCart\Mapping\StatusInterface,
    CmsShoppingCart\Options\ModuleOptionsInterface;

/**
 * Shopping cart service
 *
 * @author Dmitry Popov <d.popov@altgraphic.com>
 *
 * @method ModuleOptionsInterface getOptions()
 */
class ShoppingCart implements ShoppingCartInterface
{
    use DomainServiceProviderTrait,
        CurrencyListAwareTrait,
        OptionsProviderTrait,
        ServiceLocatorAwareTrait;

    /**
     * __construct
     *
     * @param ModuleOptionsInterface $options
     * @param ServiceLocatorInterface $services
     */
    public function __construct(
        ModuleOptionsInterface $options,
        ServiceLocatorInterface $services
    ) {
        $this->setOptions($options);
        $this->setServiceLocator($services);
    }

    /**
     * @return void
     */
    protected function init()
    {
        $cart = $this->getFromSession();
        if ($cart && $cart->getStatus()->equals(StatusInterface::STATUS_INITIALIZED)) {
            return;
        }

        $service = $this->getDomainService();
        $service->getSessionContainer()->shoppingCart = $service->getMapper()->create([
                'price' => new Money(0, $this->getCurrencyList()->getDefault()),
                'status' => StatusInterface::STATUS_INITIALIZED,
            ]);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        $cart = $this->getFromSession();
        if (null === $cart) {
            return true;
        }

        return !!$this->count();
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        $cart = $this->getFromSession();
        if (null === $cart) {
            return 0;
        }

        $this->init();
        return count($this->getFromSession());
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        $cart = $this->getFromSession();
        if (null === $cart) {
            return 0;
        }

        $this->init();
        return $this->getFromSession()->getQuantity();
    }

    /**
     * @return Money
     */
    public function getPrice()
    {
        $cart = $this->getFromSession();
        if (null === $cart) {
            return new Money(0, $this->getCurrencyList()->getDefault());
        }

        $this->init();
        return $this->getFromSession()->getPrice();
    }

    /**
     * @return ItemInterface[]
     */
    public function getItems()
    {
        $cart = $this->getFromSession();
        if (null === $cart) {
            return [];
        }

        $this->init();
        return $this->getFromSession()->getItems();
    }

    /**
     * @return ItemInterface[]
     */
    public function getIterator()
    {
        $items = $this->getItems();
        if ($items instanceof Iterator) {
            return $items;
        }

        return new ArrayIterator($items);
    }

    /**
     * Proxy to Shopping Cart persistent object
     *
     * @param string $method
     * @param array $argv
     * @return mixed
     */
    public function __call($method, $argv)
    {
        $this->init();

        $cart = $this->getFromSession();
        $result = call_user_func_array([$cart, $method], $argv);

        if ($cart->getStatus()->equals(StatusInterface::STATUS_PENDING)) {
            $this->getDomainService()->getMapper()->save($cart);
        }

        return $result;
    }

    /**
     * @return null|CartInterface
     */
    private function getFromSession()
    {
        $sessionContainer = $this->getDomainService()->getSessionContainer();

        if (isset($sessionContainer->shoppingCart)) {
            return $sessionContainer->shoppingCart;
        }
    }

    /**
     * @return CurrencyListInterface
     */
    public function getCurrencyList()
    {
        if (null === $this->currencyList) {
            $this->setCurrencyList(
                $this->getServiceLocator()->get($this->getOptions()->getCurrencyListClass())
            );
        }

        return $this->currencyList;
    }

    /**
     * @return DomainServiceInterface
     */
    public function getDomainService()
    {
        if (null === $this->domainService) {
            $this->setDomainService(
                $this->getServiceLocator()->get('DomainServiceManager')
                    ->get($this->getOptions()->getShoppingCartClass())
            );
        }

        return $this->domainService;
    }
}
