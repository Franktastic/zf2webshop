<?php

namespace Order\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Order\Model\Order;
use Order\Model\OrderHistory;

use Order\Model\Customer;
use Order\Form\CustomerForm;

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
    public function createOrder($cart, $customer)
    {
        $customerCheck = $this->objectManager
            ->getRepository('Order\Model\Customer')
            ->findOneBy(array(
                'firstname' => $customer->getFirstname(),
                'surname' => $customer->getSurname(),
                'email' => $customer->getEmail()
            ));

        //If customer exists use that one, otherwise save as new customer
        if (!empty($customerCheck)) {
            $customer = $customerCheck;
        } else {
            $this->objectManager->persist($customer);
            $this->objectManager->flush();
        }

        $totalPrice = 0;

        foreach ($cart as $product) {
            $totalPrice = $totalPrice + ($product['quantity']*$product['product']->getPrice());
        }

        $date = new \DateTime("now");

        $order = new Order();
        $order->setPrice($totalPrice);
        $order->setDate($date);
        $order->setCustomer($customer);

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
        return array(
            'order' => $order,
            'customer' => $customer
        );
    }

    /**
     * @return $form
     */
    public function createForm()
    {
        $form = new CustomerForm();
        $form->get('submit')->setValue('Bestel');
        return $form;
    }

}