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
     * @return array
     */
    public function getCart()
    {
        $result = [];
        foreach ($this->sessionContainer->cart as $line) {
            $result[] = [
                'quantity' => $line['quantity'],
                'product' => $this->catalogService->getProduct($line['product'])
            ];
        }
        return $result;
    }

    /**
     * @return Cart[]
     */
    public function addToCart($productId)
    {
        $productExist = false;

        foreach ($this->sessionContainer->cart as $key => $value) {
            if ($value['product'] === $productId) {
                $this->sessionContainer->cart[$key]['quantity']++;
                $productExist = true;
            }
        }

        if ($productExist == false) {
            $insertInSession = array('quantity' => 1, 'product' => $productId);
            $this->sessionContainer->cart[] = $insertInSession;
        }

        return $this->sessionContainer->cart;
    }

    /**
     * @return void
     */
    public function emptyCart()
    {
        unset($this->sessionContainer->cart);
    }

}