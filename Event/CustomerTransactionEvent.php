<?php

namespace Clamidity\AuthNetBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Clamidity\AuthNetBundle\Model\CustomerProfile\CustomerProfileInterface;

/**
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class CustomerTransactionEvent extends Event
{
    protected $customerProfile;
    protected $transactionId;
    protected $amount;
    protected $user;

    public function __construct(CustomerProfileInterface $customerProfile, $transactionId, $amount, $user = null)
    {
        $this->customerProfile = $customerProfile;
        $this->transactionId = $transactionId;
        $this->amount = $amount;
        $this->user = $user;
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

    public function getUser()
    {
        return $this->user;
    }
}