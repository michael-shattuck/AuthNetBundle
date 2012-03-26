<?php

namespace Clamidity\AuthNetBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Clamidity\AuthNetBundle\Entity\CustomerProfile;

/**
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class CustomerAddressEvent extends Event
{
    protected $customerProfile;
    protected $addressId;

    public function __construct(CustomerProfile $customerProfile, $addressId)
    {
        $this->customerProfile = $customerProfile;
        $this->addressId = $addressId;
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
}