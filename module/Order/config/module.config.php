<?php
namespace Order;

use Order\Controller\OrderController;

return array(
    'doctrine' => array(
        'driver' => array(
            'orm_default' => array(
                'drivers' => array(
                    'Order' => 'annotation_driver'
                )
            ),
            'annotation_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/Order/Model'
                )
            )
        )
    ),

    'controllers' => array(
        'invokables' => array(
            'Order\Controller\Order' => 'Order\Controller\OrderController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'order' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/order[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Order\Controller\Order',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),


    'view_manager' => array(
        'template_path_stack' => array(
            'order' => __DIR__ . '/../view',
        ),
    ),
);