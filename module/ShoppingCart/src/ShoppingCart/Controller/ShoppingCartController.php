<?php
namespace ShoppingCart\Controller;

use ShoppingCart\Model\ShoppingCart;
use ShoppingCart\Service\ShoppingCartService;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ShoppingCartController extends AbstractActionController
{

    /**
     * @param ShoppingCartService $shoppingCartService
     */
    function __construct(ShoppingCartService $shoppingCartService)
    {
        $this->shoppingCartService = $shoppingCartService;
    }

    public function viewAction()
    {
        //Read session and echo
    }

}