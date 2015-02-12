<?php
namespace Category\Controller;

use Category\Model\Category;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container as SessionContainer;

class ProductController extends AbstractActionController
{
    public function viewAction()
    {
        $productId = (int) $this->params()->fromRoute('id', 0);
        if (!$productId) {
            return $this->redirect()->toRoute('category', array(
                'action' => 'index'
            ));
        }

        $catalogService = $this->getServiceLocator()->get('CatalogService');
        $product = $catalogService->getProduct($productId);

        //\Doctrine\Common\Util\Debug::dump($product);
        return new ViewModel([
            'product' => $product
        ]);
    }

    public function addToCartAction() {
        $productId = (int) $this->params()->fromRoute('id', 0);
        if (!$productId) {
            return $this->redirect()->toRoute('category', array(
                'action' => 'index'
            ));
        }

        //Session stuff
        $session = new SessionContainer('cart');

        if (!isset($session->cart)) {
            $session->cart = [];
        }

        $item = [];
        $item['id'] = $productId;
        $item['quantity'] = 1;
        $session->cart[] = $item;

        return $this->redirect()->toRoute('category', array(
            'action' => 'index'
        ));
    }

}