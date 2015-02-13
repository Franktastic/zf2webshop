<?php
namespace ShoppingCart\Controller;

use Category\Service\CatalogService;
use ShoppingCart\Model\ShoppingCart;
use ShoppingCart\Service\ShoppingCartService;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ShoppingCartController extends AbstractActionController
{

    /**
     * @param ShoppingCartService $shoppingCartService
     */
    function __construct(ShoppingCartService $shoppingCartService, CatalogService $catalogService)
    {
        $this->catalogService = $catalogService;
        $this->shoppingCartService = $shoppingCartService;
    }
}