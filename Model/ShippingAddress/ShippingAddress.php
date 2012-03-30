<?php

namespace Clamidity\AuthNetBundle\Model\ShippingAddress;

use Clamidity\AuthNetBundle\Model\CustomerProfile\CustomerProfileInterface;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
abstract class ShippingAddress implements ShippingAddressInterface
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $shippingAddressId
     */
    protected $shippingAddressId;

    /**
     * @var datetime $created_at
     */
    protected $created_at;

    /**
     * @var datetime $modified_at
     */
    protected $modified_at;

    /**
     * @var type AuthorizeNetCustomer
     */
    protected $customer;

    /**
     * @var type string
     */
    protected $address;

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
    public function setCustomer(CustomerProfileInterface $customer)
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

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getAddress()
    {
        return $this->address;
    }
}