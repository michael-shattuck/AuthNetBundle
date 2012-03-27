<?php

namespace Clamidity\AuthNetBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Clamidity\AuthNetBundle\Entity\CustomerProfile;

/**
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class CustomerTransactionEvent extends Event
{
    protected $customerProfile;
    protected $transactionId;
    protected $amount;

    public function __construct(CustomerProfile $customerProfile, $transactionId, $amount)
    {
        $this->customerProfile = $customerProfile;
        $this->transactionId = $transactionId;
        $this->amount = $amount;
    }

    /**
     * @return CustomerProfile 
     */
    public function getCustomerProfile()
    {
        return $this->customerProfile;
    }

    public function getTransactionId()
    {
        return $this->transactionId;
    }

    public function getAmount()
    {
        return $this->amount;
    }
}