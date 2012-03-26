<?php

namespace Clamidity\AuthNetBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Clamidity\AuthNetBundle\Entity\CustomerProfile;

/**
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class CustomerPaymentProfileEvent extends Event
{
    protected $customerProfile;
    protected $paymentProfileId;

    public function __construct(CustomerProfile $customerProfile, $paymentProfileId)
    {
        $this->customerProfile = $customerProfile;
        $this->paymentProfileId = $paymentProfileId;
    }

    /**
     * @return CustomerProfile 
     */
    public function getCustomerProfile()
    {
        return $this->customerProfile;
    }

    public function getPaymentProfileId()
    {
        return $this->paymentProfileId;
    }
}