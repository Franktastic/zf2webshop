<?php
namespace Order\Model;

use Doctrine\ORM\Mapping as ORM;
/** @ORM\Entity */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;



}