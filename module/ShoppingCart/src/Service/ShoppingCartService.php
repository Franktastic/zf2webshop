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
        $this->sessionContainer = new SessionContainer('cart');
    }

    /**
     * @return Cart[]
     */
    public function getCart()
    {
        return $this->sessionContainer;
    }

    /**
     * @return Cart[]
     */
    public function addToCart($productId)
    {
        $catalogService = $this->getServiceLocator()->get('CatalogService');
        $product = $catalogService->getProduct($productId);

        if (!isset($this->sessionContainer)) {
            $this->sessionContainer = [];
        }

        $item = [];
        $item['id'] = $productId;
        $item['quantity'] = 1;
        $this->sessionContainer[] = $item;

        return $this->sessionContainer;
    }

}