<?php
/**
 * CoolMS2 Shopping Cart Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/shopping-cart for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsShoppingCart;

return [
    'cmspermissions' => [
        'acl' => [
            'guards' => [
                'CmsAcl\Guard\Route' => [
                    ['route' => 'cms-shopping-cart', 'roles' => ['guest','user']],
                 ],
            ],
        ],
    ],
    'cmsshoppingcart' => [
        
    ],
    'controllers' => [
        'invokables' => [
            'CmsShoppingCart\Controller\Admin'  => 'CmsShoppingCart\Mvc\Controller\AdminController',
            'CmsShoppingCart\Controller\Index'  => 'CmsShoppingCart\Mvc\Controller\IndexController',
        ],
    ],
    'controller_plugins' => [
        'aliases' => [
            'cmsShoppingCart' => 'CmsShoppingCart\Mvc\Controller\Plugin\ShoppingCart',
        ],
        'factories' => [
            'CmsShoppingCart\Mvc\Controller\Plugin\ShoppingCart'
                => 'CmsShoppingCart\Factory\Mvc\Controller\Plugin\ShoppingCartPluginFactory',
        ],
    ],
    'navigation' => [
        'cmsuseridentity' => [
            [
                'label' => 'Cart',
                'label_helper' => 'cmsShoppingCart',
                'text_domain' => __NAMESPACE__,
                'route' => 'cms-shopping-cart',
                'resource' => 'route/cms-shopping-cart',
                'order' => -100,
                'twbs' => [
                    'icon' => [
                        'type' => 'fa',
                        'content' => 'shopping-cart',
                        'placement' => 'prepend',
                        'tagName' => 'i',
                    ],
                ],
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'cms-shopping-cart' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/shopping-cart',
                    'defaults' => [
                        '__NAMESPACE__' => 'CmsShoppingCart\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ],
                    'may_terminate' => true,
                    'child_routes' => [
                        'default' => [
                            'type' => 'Segment',
                            'options' => [
                                'route' => '[/:action]',
                                'constraints' => [
                                    'action' => '[a-zA-Z\-]*',
                                ],
                                'defaults' => [
                                    '__NAMESPACE__' => 'CmsShoppingCart\Controller',
                                    'controller' => 'Index',
                                    'action' => 'index',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'cms-admin' => [
                'child_routes' => [
                    'shopping-cart' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => 'shopping-cart[/:controller[/:action[/:id]]]',
                            'constraints' => [
                                'controller' => '[a-zA-Z\-]*',
                                'action' => '[a-zA-Z\-]*',
                                'id' => '[0-9]*',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'CmsShoppingCart\Controller',
                                'controller' => 'Admin',
                                'action' => 'index',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'aliases' => [
            'CmsShoppingCart\Options\ModuleOptionsInterface' => 'CmsShoppingCart\Options\ModuleOptions',
            'CmsShoppingCart\Service\ShoppingCartInterface'  => 'CmsShoppingCart\Service\ShoppingCart',
        ],
        'factories' => [
            'CmsShoppingCart\Options\ModuleOptions' => 'CmsShoppingCart\Factory\ModuleOptionsFactory',
            'CmsShoppingCart\Service\ShoppingCart'  => 'CmsShoppingCart\Factory\ShoppingCartFactory',
        ],
    ],
    'translator' => [
        'translation_file_patterns' => [
            [
                'type'          => 'gettext',
                'base_dir'      => __DIR__ . '/../language',
                'pattern'       => '%s.mo',
                'text_domain'   => __NAMESPACE__,
            ],
            [
                'type'          => 'phpArray',
                'base_dir'      => __DIR__ . '/../language',
                'pattern'       => '%s.php',
            ],
        ],
    ],
    'view_helpers' => [
        'factories' => [
            'cmsShoppingCart' => 'CmsShoppingCart\Factory\View\Helper\ShoppingCartHelperFactory',
        ],
        'invokables' => [
            'cmsShoppingCartWidget' => 'CmsShoppingCart\View\Helper\ShoppingCartWidget',
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __NAMESPACE__ => __DIR__ . '/../view',
        ],
    ],
];
