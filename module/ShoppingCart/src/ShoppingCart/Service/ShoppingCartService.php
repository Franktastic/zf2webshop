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

        //var_dump($product);
        //\Doctrine\Common\Util\Debug::dump($product->getTitle());
        //exit();

        if (!isset($this->sessionContainer->cart)) {
            $this->sessionContainer->cart = [];
        }

        $item = [];
        $item['id'] = $productId;
        $item['title'] = $product->getTitle();
        $item['desc'] = $product->getDescription();
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