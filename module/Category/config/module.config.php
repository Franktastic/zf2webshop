<?php

namespace Category;

use Category\Controller\CategoryController;
use Category\Service\CatalogService;

return array(
    'doctrine' => array(
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
                    __DIR__ . '/../src/Category/Model'
                )
            )
        )
    ),

    'controllers' => array(
        'invokables' => array(
            'Category\Controller\Product' => 'Category\Controller\ProductController',
        ),
        'factories' => [
            'Category\Controller\Category' => 'Category\Controller\CategoryControllerFactory'
        ]
    ),

    'service_manager' => [
        'factories' => [
            'CatalogService' => function ($sm) {
                $objectManager = $sm->get('Doctrine\ORM\EntityManager');

                $service = new CatalogService($objectManager);

                return $service;
            }
        ]
    ],

    'router' => array(
        'routes' => array(
            'category' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/category[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Category\Controller\Category',
                        'action'     => 'index',
                    ),
                ),
            ),
            'product' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/product[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Category\Controller\Product',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),


    'view_manager' => array(
        'template_path_stack' => array(
            'category' => __DIR__ . '/../view',
        ),
    ),
);