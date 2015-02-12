<?php
namespace ShoppingCart\Service;

use Category\Service\CatalogService;

use Zend\Session\Container as SessionContainer;

class ShoppingCartService
{
    /**
     * @var SessionContainer
     */
    protected $sessionContainer;

    /**
     * @param SessionContainer $sessionContainer
     */
    function __construct(SessionContainer $sessionContainer)
    {
        $this->sessionContainer = $sessionContainer;
    }

    /**
     * @return Cart[]
     */
    public function getCart()
    {
        return $this->sessionContainer->cart;
    }

    /**
     * @return Cart[]
     */
    public function addToCart($productId)
    {
        //$catalogService = $this->getServiceLocator()->get('CatalogService');
        //$product = $catalogService->getProduct($productId);

        if (!isset($this->sessionContainer->cart)) {
            $this->sessionContainer->cart = [];
        }

        $item = [];
        $item['id'] = $productId;
        $item['quantity'] = 1;
        $this->sessionContainer->cart[] = $item;

        var_dump($this->sessionContainer->cart);

        return $this->sessionContainer->cart;
    }

    /**
     * @return Cart[]
     */
    public function clearSession()
    {
        $this->sessionContainer->cart = [];
        return false;
        //return $this->sessionContainer;
    }

}