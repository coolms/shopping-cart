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

use ArrayIterator,
    Countable,
    Iterator,
    IteratorAggregate,
    Zend\I18n\View\Helper\AbstractTranslatorHelper,
    CmsMoney\View\Helper\MoneyFormat,
    CmsShoppingCart\Mapping\ItemInterface,
    CmsShoppingCart\Service\ShoppingCartAwareTrait,
    CmsShoppingCart\Service\ShoppingCartInterface;

/**
 * View helper for shopping cart
 */
class ShoppingCart extends AbstractTranslatorHelper implements Countable, IteratorAggregate
{
    use ShoppingCartAwareTrait;

    /**
     * @var string
     */
    protected $pattern = 'Cart (%s) %s';

    /**
     * @var MoneyFormat
     */
    protected $moneyFormatter;

    /**
     * @var string
     */
    protected $defaultMoneyFormatter = 'moneyFormat';

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
        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        $count = $this->count();
        $price = $this->getPrice();

        $pattern = $this->getPattern();
        if ($translator = $this->getTranslator()) {
            $pattern = $translator->translate($pattern, $this->getTranslatorTextDomain());
        }

        $moneyFormatter = $this->getMoneyFormatter();

        return sprintf(
            $pattern,
            $count,
            (string) $moneyFormatter($price)
        );
    }

    /**
     * @return MoneyFormat
     */
    protected function getMoneyFormatter()
    {
        if ($this->moneyFormatter) {
            return $this->moneyFormatter;
        }

        if (method_exists($this->view, 'plugin')) {
            $this->moneyFormatter = $this->view->plugin($this->defaultMoneyFormatter);
        }

        if (!$this->moneyFormatter instanceof MoneyFormat) {
            $this->setMoneyFormatter(new MoneyFormat());
            $this->moneyFormatter->setView($this->getView());
        }

        return $this->moneyFormatter;
    }

    /**
     * @param MoneyFormat $formatter
     * @return self
     */
    public function setMoneyFormatter(MoneyFormat $formatter)
    {
        $this->moneyFormatter = $formatter;
        return $this;
    }

    /**
     * @param string $pattern
     * @return self
     */
    public function setPattern($pattern)
    {
        $this->pattern = (string) $pattern;
        return $this;
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
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

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return count($this->getShoppingCart());
    }

    /**
     * @return ItemInterface[]
     */
    public function getIterator()
    {
        return $this->getShoppingCart()->getIterator();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        try {
            $markup = $this->render();
        } catch (\Exception $e) {
            $markup = $e->getMessage();
        }

        return $markup;
    }
}
