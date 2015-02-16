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

        $this->sessionContainer->cart[] = $product;

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