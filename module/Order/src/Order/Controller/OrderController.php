<?php
namespace Order\Controller;

use Order\Model\Order;
use Category\Model\Product;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class OrderController extends AbstractActionController
{

    public function indexAction()
    {
        /*Need the products with their prices here
          Create a service to do so?
        */

        $catalogService = $this->getServiceLocator()->get('catalogService');
        $categories = $catalogService->getCategories();

        $shoppingCartService = $this->getServiceLocator()->get('ShoppingCartService');
        $cart = $shoppingCartService->getCart();

        //\Doctrine\Common\Util\Debug::dump($cart);

        return new ViewModel([
            'categories' => $categories,
            'cart'  =>  $cart
        ]);
    }

}