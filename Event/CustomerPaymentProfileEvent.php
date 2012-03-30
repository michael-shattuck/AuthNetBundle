<?php

namespace Clamidity\AuthNetBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Clamidity\AuthNetBundle\Model\CustomerProfile\CustomerProfileInterface;

/**
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class CustomerPaymentProfileEvent extends Event
{
    protected $customerProfile;
    protected $paymentProfileId;
    protected $accountNumber;

    public function __construct(CustomerProfileInterface $customerProfile, $paymentProfileId, $accountNumber)
    {
        $this->customerProfile = $customerProfile;
        $this->paymentProfileId = $paymentProfileId;
        $this->accountNumber = $accountNumber;
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

    public function getAccountNumber()
    {
        return $this->accountNumber;
    }
}