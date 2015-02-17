<?php
namespace Order\Controller;

use Order\Model\Order;
use Order\Model\OrderHistory;
use Category\Model\Product;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Model\ViewModel;

class OrderController extends AbstractActionController
{

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
        $catalogService = $this->getServiceLocator()->get('CatalogService');
        $shoppingCartService = $this->getServiceLocator()->get('ShoppingCartService');
        $cart = $shoppingCartService->getCart();

        $totalprice = 0;

        foreach ($cart as $product) {
            $totalprice = $totalprice + ($product['quantity']*$product['product']->getPrice());
        }

        $date = new \DateTime("now");

        $order = new Order();
        $order->setPrice($totalprice);
        $order->setDate($date);

        $objectManager = $this
            ->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');

        $objectManager->persist($order);
        $objectManager->flush();

        foreach ($cart as $product) {
            $orderHistory = new OrderHistory();

            $orderHistory->setOrder($order);
            $setProduct = $catalogService->getProduct($product['product']->getId());
            $orderHistory->setProduct($setProduct);
            $orderHistory->setProductPrice($setProduct->getPrice());
            $orderHistory->setQuantity($product['quantity']);

            $objectManager->persist($orderHistory);
            $objectManager->flush();
        }
    }

}