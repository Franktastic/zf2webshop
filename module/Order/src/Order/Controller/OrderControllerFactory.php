<?php
namespace Order\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class OrderControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $orderService = $sm->getServiceLocator()->get('OrderService');

        $controller = new OrderController($orderService);

        return $controller;
    }
}