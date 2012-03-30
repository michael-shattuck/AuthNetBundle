<?php

namespace Clamidity\AuthNetBundle\Model\ShippingAddress;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
Interface ShippingAddressInterface
{

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId();

    /**
     * Set ShippingAddressId
     *
     * @param string $shippingAddressId
     * @return ShippingAddress
     */
    public function setShippingAddressId($shippingAddressId);

    /**
     * Get ShippingAddressId
     *
     * @return string 
     */
    public function getShippingAddressId();

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return ShippingAddress
     */
    public function setCreatedAt($createdAt);

    /**
     * Get created_at
     *
     * @return datetime 
     */
    public function getCreatedAt();

    /**
     * Set modified_at
     *
     * @param datetime $modifiedAt
     * @return ShippingAddress
     */
    public function setModifiedAt($modifiedAt);

    /**
     * Get modified_at
     *
     * @return datetime 
     */
    public function getModifiedAt();

    /**
     * Set customer
     *
     * @param CustomerProfile $customer
     * @return ShippingAddress
     */
    public function setCustomer($customer);

    /**
     * Get customer
     *
     * @return CustomerProfile 
     */
    public function getCustomer();

    public function setAddress($address);

    public function getAddress();
}