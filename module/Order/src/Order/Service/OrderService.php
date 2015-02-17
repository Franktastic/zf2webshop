<?php

namespace Order\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Order\Model\Order;
use Order\Model\OrderHistory;

class OrderService
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @param ObjectManager $objectManager
     */
    function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @return Order[]
     */
    public function getOrders()
    {
        return $this->objectManager
            ->getRepository('Order\Model\Order')
            ->findAll();
    }

    /**
     * @return Order[]
     */
    public function createOrder($cart)
    {
        $totalprice = 0;

        foreach ($cart as $product) {
            $totalprice = $totalprice + ($product['quantity']*$product['product']->getPrice());
        }

        $date = new \DateTime("now");

        $order = new Order();
        $order->setPrice($totalprice);
        $order->setDate($date);

        $this->objectManager->persist($order);
        $this->objectManager->flush();

        foreach ($cart as $product) {
            $orderHistory = new OrderHistory();

            $orderHistory->setOrder($order);
            $setProduct = $product['product'];
            $orderHistory->setProduct($setProduct);
            $orderHistory->setProductPrice($setProduct->getPrice());
            $orderHistory->setQuantity($product['quantity']);

            $this->objectManager->persist($orderHistory);
            $this->objectManager->flush();
        }
        return $order;
    }
}