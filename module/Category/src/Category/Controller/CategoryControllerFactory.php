<?php
namespace Category\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CategoryControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $catalogService = $sm->getServiceLocator()->get('CatalogService');

        $controller = new CategoryController($catalogService);

        return $controller;
    }
}