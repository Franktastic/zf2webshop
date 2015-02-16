<?php
namespace ShoppingCart\Service;

use Category\Service\CatalogService as CatalogService;

use Category\Model\Product;

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

        if (!$this->sessionContainer->cart) {
            $this->sessionContainer->cart = [];
        }
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

        $productExist = false;

        foreach ($this->sessionContainer->cart as $key => $value) {
            $productvalue = $value['product'];

            if ($productvalue->getId() === $productId) {
                $this->sessionContainer->cart[$key]['quantity']++;
                $productExist = true;
            }
        }

        if ($productExist == false) {
            $insertInSession = array('quantity' => 1, 'product' => $product);
            $this->sessionContainer->cart[] = $insertInSession;
        }

        return $this->sessionContainer->cart;
    }

    /**
     * @return Cart[]
     */
    public function clearSession()
    {
        unset($this->sessionContainer->cart);
    }

}