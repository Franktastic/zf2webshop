<?php

namespace Category\Service;

use Doctrine\Common\Persistence\ObjectManager;

class CatalogService
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
     * @return Category[]
     */
    public function getCategories()
    {
        return $this->objectManager
            ->getRepository('Category\Model\Category')
            ->findAll();
    }

    /**
     * @return Product[]
     */
    public function getProducts($categoryId)
    {
        return $this->objectManager
            ->getRepository('Category\Model\Product')
            ->findBy(array('category' => $categoryId));
    }

    /**
     * @return Product[]
     */
    public function getProduct($productId)
    {
        return $this->objectManager
            ->getRepository('Category\Model\Product')
            ->findOneBy(array('id' => $productId));
    }
}