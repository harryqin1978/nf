<?php
namespace NF\CommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="nf_order",indexes={@ORM\Index(name="idx_price", columns={"price"}), @ORM\Index(name="idx_receive_name", columns={"receive_name"})})
 */
class Order
{
    /**
     * @ORM\ManyToOne(targetEntity="\NF\UserBundle\Entity\User", inversedBy="orders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="price", type="decimal", scale=2)
     */
    protected $price;

    /**
     * @ORM\Column(name="receive_name", type="string", length=100)
     */
    protected $receiveName;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Order
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set receiveName
     *
     * @param string $receiveName
     * @return Order
     */
    public function setReceiveName($receiveName)
    {
        $this->receiveName = $receiveName;

        return $this;
    }

    /**
     * Get receiveName
     *
     * @return string 
     */
    public function getReceiveName()
    {
        return $this->receiveName;
    }

    /**
     * Set user
     *
     * @param \NF\UserBundle\Entity\User $user
     * @return Order
     */
    public function setUser(\NF\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \NF\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
