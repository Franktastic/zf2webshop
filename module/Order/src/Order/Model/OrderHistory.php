<?php
namespace Order\Model;

use Category\Model\Product;

use Doctrine\ORM\Mapping as ORM;
/** @ORM\Entity */
class OrderHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="orderhistory")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $order;

    /**
     * @ORM\ManyToOne(targetEntity="Category\Model\Product", cascade={"persist"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     **/
    protected $product;

    /** @ORM\Column(type="decimal") */
    protected $product_price;

    /** @ORM\Column(type="decimal") */
    protected $quantity;

    /**
     * @param Order $order
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @param $productPrice
     * @return $this
     */
    public function setProductPrice($productPrice)
    {
        $this->product_price = $productPrice;
        return $this;
    }

    /**
     * @param $quantity
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return $product
     */
    public function getHistoryProduct()
    {
        return $this->product;
    }

    /**
     * @return $quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

}