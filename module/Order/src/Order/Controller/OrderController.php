<?php
namespace Order\Controller;

use Order\Model\Order;
use Order\Model\OrderHistory;
use Category\Model\Product;
use Order\Service\OrderService;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Model\ViewModel;

class OrderController extends AbstractActionController
{
    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * @param OrderService $orderService
     */
    function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function indexAction()
    {
        $shoppingCartService = $this->getServiceLocator()->get('ShoppingCartService');
        $cart = $shoppingCartService->getCart();

        return new ViewModel([
            'cart'  =>  $cart
        ]);
    }

    public function orderAction()
    {
        //$catalogService = $this->getServiceLocator()->get('CatalogService');
        $shoppingCartService = $this->getServiceLocator()->get('ShoppingCartService');
        $cart = $shoppingCartService->getCart();

        if (empty($cart)) {
            return $this->redirect()->toRoute('order', array(
                'action' => 'index'
            ));
        }

        $order = $this->orderService->createOrder($cart);

        $shoppingCartService->emptyCart();

        return new ViewModel([
            'order' => $order
        ]);
    }

    public function viewAction()
    {

    }

}