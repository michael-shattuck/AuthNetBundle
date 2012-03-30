<?php

namespace Clamidity\AuthNetBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Clamidity\AuthNetBundle\Model\CustomerProfile\CustomerProfileInterface;

/**
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class CustomerAddressEvent extends Event
{
    protected $customerProfile;
    protected $addressId;
    protected $address;

    public function __construct(CustomerProfileInterface $customerProfile, $addressId, $address)
    {
        $this->customerProfile = $customerProfile;
        $this->addressId = $addressId;
        $this->address = $address;
    }

    /**
     * @return CustomerProfile 
     */
    public function getCustomerProfile()
    {
        return $this->customerProfile;
    }

    public function getAddressId()
    {
        return $this->addressId;
    }

    public function getAddress()
    {
        return $this->address;
    }
}