<?php

namespace Clamidity\AuthNetBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Clamidity\AuthNetBundle\Model\CustomerProfile\CustomerProfileInterface;

/**
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class CustomerProfileEvent extends Event
{
    protected $customerProfile;

    public function __construct(CustomerProfileInterface $customerProfile)
    {
        $this->customerProfile = $customerProfile;
    }

    public function getCustomerProfile()
    {
        return $this->customerProfile;
    }
}
