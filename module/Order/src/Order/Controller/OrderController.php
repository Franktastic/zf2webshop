<?php
namespace Order\Controller;

use Order\Model\Customer;
use Order\Form\CustomerForm;
use Order\Service\OrderService;

use Zend\Mvc\Controller\AbstractActionController;
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

        $form = $this->orderService->createForm();

        return new ViewModel([
            'form' => $form,
            'cart'  =>  $cart
        ]);
    }

    public function orderAction()
    {
        $shoppingCartService = $this->getServiceLocator()->get('ShoppingCartService');
        $cart = $shoppingCartService->getCart();

        if (empty($cart)) {
            return $this->redirect()->toRoute('order', array(
                'action' => 'index'
            ));
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $customer = new Customer();
            $form = new CustomerForm();
            $form->setInputFilter($customer->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $customer->setData($form->getData());

                //Save customer and data
                $orderData = $this->orderService->createOrder($cart, $customer);
                $shoppingCartService->emptyCart();

                return new ViewModel($orderData);
            } else {
                //Should add flashmessage or something like that for feedback
                return $this->redirect()->toRoute('order', array(
                    'action' => 'index',
                    'form' => $form
                ));
            }
        }
    }

    public function viewAction()
    {
        $orders = $this->orderService->getOrders();

        return new ViewModel([
            'orders' => $orders
        ]);
    }

}