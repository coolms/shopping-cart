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

use Zend\ServiceManager\ServiceLocatorAwareTrait,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsCommon\Service\DomainServiceProviderTrait,
    CmsCommon\Stdlib\OptionsProviderTrait,
    CmsMoney\Service\CurrencyListAwareTrait,
    CmsShoppingCart\Mapping\CartInterface,
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
     * Creates new shopping cart instance
     *
     * @return CartInterface
     */
    protected function create()
    {
        $currency = $this->getCurrencyList()->getDefault();

        $cart = $this->getDomainService()->getMapper()->create(compact('currency'));

        $eventManager = $this->getEventManager();
        $eventManager->trigger(__FUNCTION__, $this, $cart);

        return $cart;
    }

    /**
     * @return CartInterface
     */
    protected function get()
    {
        $sessionContainer = $this->getDomainService()->getSessionContainer();

        /* @var $cart CartInterface */
        if (($cart = $sessionContainer->shoppingCart) &&
            $cart->getStatus()->equals(StatusInterface::STATUS_INITIALIZED)
        ) {
            return $cart;
        }

        $cart = $this->create();
        $sessionContainer->shoppingCart = $cart;

        return $cart;
    }

    /**
     * Proxy to Shopping Cart persistent object
     *
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([$this->get(), $method], $args);
    }

    /**
     * @return \CmsCommon\Service\DomainServiceInterface
     */
    public function getDomainService()
    {
        if (null === $this->domainService) {
            $service = $this->getServiceLocator()->get('DomainServiceManager')
                ->get($this->getOptions()->getShoppingCartClass());
            $this->setDomainService($service);
        }

        return $this->domainService;
    }
}
