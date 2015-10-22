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

interface ModuleOptionsInterface
{
    /**
     * @return string
     */
    public function getShoppingCartClass();

    /**
     * @param string $class
     * @return self
     */
    public function setShoppingCartClass($class);
}
