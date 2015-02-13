<?php
namespace ShoppingCart\Service;

use Category\Service\CatalogService as CatalogService;

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
    function __construct(SessionContainer $sessionContainer, CatalogService $catalogService)
    {
        $this->sessionContainer = $sessionContainer;
        $this->catalogService = $catalogService;
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

        $product = $this->catalogService->getProduct($productId);

        if (!isset($this->sessionContainer->cart)) {
            $this->sessionContainer->cart = [];
        }

        $productExist = false;

        foreach ($this->sessionContainer->cart as $key => $value) {
            if ($value['id'] == $productId) {
                $this->sessionContainer->cart[$key]['quantity']++;
                $productExist = true;
            }
        }

        if ($productExist == false) {
            $item = [];
            $item['quantity'] = 1;
            $item['id'] = $productId;
            $item['title'] = $product->getTitle();
            $item['desc'] = $product->getDescription();
            $this->sessionContainer->cart[] = $item;
        }

        return $this->sessionContainer->cart;
    }

    /**
     * @return Cart[]
     */
    public function clearSession()
    {
        $this->sessionContainer->cart = [];
        return false;
    }

}