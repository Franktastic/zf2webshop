<?php
namespace Category\Controller;

use Category\Model\Category;

use Category\Service\CatalogService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CategoryController extends AbstractActionController
{
    /**
     * @var CatalogService
     */
    protected $catalogService;

    /**
     * @param CatalogService $catalogService
     */
    function __construct(CatalogService $catalogService)
    {
        $this->catalogService = $catalogService;
    }

    public function indexAction()
    {
        $categories = $this->catalogService->getCategories();

        $shoppingCartService = $this->getServiceLocator()->get('ShoppingCartService');
        $cart = $shoppingCartService->getCart();

        //\Doctrine\Common\Util\Debug::dump($cart);

        return new ViewModel([
            'categories' => $categories,
            'cart'  =>  $cart
        ]);
    }

    public function viewAction()
    {
        $categoryId = (int) $this->params()->fromRoute('id', 0);
        if (!$categoryId) {
            return $this->redirect()->toRoute('category', array(
                'action' => 'index'
            ));
        }

        $products = $this->catalogService->getProducts($categoryId);

        //\Doctrine\Common\Util\Debug::dump($products);
        return new ViewModel([
            'products' => $products
        ]);
    }

    public function clearSessionAction() {
        $shoppingCartService = $this->getServiceLocator()->get('ShoppingCartService');
        $shoppingCartService->clearSession();

        return $this->redirect()->toRoute('category', array(
            'action' => 'index'
        ));
    }

}