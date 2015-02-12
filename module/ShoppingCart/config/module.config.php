<?php

namespace ShoppingCart;

//use ShoppingCart\Service\ShoppingCartService;

return array(
    /*'doctrine' => array(
        'driver' => array(
            'orm_default' => array(
                'drivers' => array(
                    'Category' => 'annotation_driver'
                )
            ),
            'annotation_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/ShoppingCart/Model'
                )
            )
        )
    ),*/

    'controllers' => array(
        'invokables' => array(
            'ShoppingCart\Controller\ShoppingCart' => 'ShoppingCart\Controller\ShoppingCartController'
        ),
    ),

    /*'service_manager' => [
        'factories' => [
            'CatalogService' => function ($sm) {
                $objectManager = $sm->get('Doctrine\ORM\EntityManager');

                $service = new CatalogService($objectManager);

                return $service;
            }
        ]
    ],*/

    'router' => array(
        'routes' => array(
            'cart' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/cart[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ShoppingCart\Controller\ShoppingCart',
                        'action'     => 'view',
                    ),
                ),
            ),
        ),
    ),


    'view_manager' => array(
        'template_path_stack' => array(
            'cart' => __DIR__ . '/../view',
        ),
    ),
);