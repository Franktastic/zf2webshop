<?php

namespace ShoppingCart\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ShoppingCartControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $shoppingCartService = $sm->getServiceLocator()->get('ShoppingCartService');

        $controller = new ShoppingCartController($shoppingCartService);

        return $controller;
    }
}