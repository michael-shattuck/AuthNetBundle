<?php

namespace Clamidity\AuthNetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clamidity\AuthNetBundle\Entity\ShippingAddress
 *
 * @ORM\Table(name="clamidity_shippingaddress")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class ShippingAddress
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $shippingAddressId
     *
     * @ORM\Column(name="shippingAddressId", type="integer", length=50)
     */
    protected $shippingAddressId;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $created_at;

    /**
     * @var datetime $modified_at
     *
     * @ORM\Column(name="modified_at", type="datetime")
     */
    protected $modified_at;

    /**
     * @var type AuthorizeNetCustomer
     * 
     * @ORM\ManyToOne(targetEntity="\Clamidity\AuthNetBundle\Entity\CustomerProfile", inversedBy="shippingAddresses")
     */
    protected $customer;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->modified_at = new \DateTime();
    }

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
     * Set ShippingAddressId
     *
     * @param string $shippingAddressId
     * @return ShippingAddress
     */
    public function setShippingAddressId($shippingAddressId)
    {
        $this->shippingAddressId = $shippingAddressId;
        return $this;
    }

    /**
     * Get ShippingAddressId
     *
     * @return string 
     */
    public function getShippingAddressId()
    {
        return $this->shippingAddressId;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return ShippingAddress
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
        return $this;
    }

    /**
     * Get created_at
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set modified_at
     *
     * @param datetime $modifiedAt
     * @return ShippingAddress
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modified_at = $modifiedAt;
        return $this;
    }

    /**
     * Get modified_at
     *
     * @return datetime 
     */
    public function getModifiedAt()
    {
        return $this->modified_at;
    }

    /**
     * Set customer
     *
     * @param CustomerProfile $customer
     * @return ShippingAddress
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
        $customer->addShippingAddress($this);
        return $this;
    }

    /**
     * Get customer
     *
     * @return CustomerProfile 
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @ORM\PreUpdate
     */
    public function doStuffOnPreUpdate()
    {
        $this->modified_at = new \DateTime();
    }
}