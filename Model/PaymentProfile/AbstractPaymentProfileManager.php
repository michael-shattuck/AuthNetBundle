<?php

namespace Clamidity\AuthNetBundle\Model\PaymentProfile;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Clamidity\AuthNetBundle\Model\PaymentProfile\PaymentProfileManagerInterface;
use Clamidity\AuthNetBundle\Model\PaymentProfile\PaymentProfileInterface;
use Clamidity\AuthNetBundle\Events;
use Clamidity\AuthNetBundle\Event\PaymentProfileEvent;

abstract class AbstractPaymentProfileManager implements PaymentProfileManagerInterface
{
    protected $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    
    /**
        *  Return a new (empty) PaymentProfile entity
        * 
        *  @return PaymentProfile
        */
    public function createPaymentProfile()
    {
        $class = $this->getClass();
        $paymentProfile = new $class();
//        $this->dispatcher->dispatch(Events::PAYMENTPROFILE_CREATE, new PaymentProfileEvent($paymentProfile));

        return $paymentProfile;
    }
    
    /**
        * Persist a PaymentProfile to the database
        * 
        *  @return void
        */
    public function savePaymentProfile(PaymentProfileInterface $paymentProfile)
    {
        $this->dispatcher->dispatch(Events::PAYMENTPROFILE_PRE_PERSIST, new PaymentProfileEvent($paymentProfile));
        $this->doSavePaymentProfile($paymentProfile);
        $this->dispatcher->dispatch(Events::PAYMENTPROFILE_POST_PERSIST, new PaymentProfileEvent($paymentProfile));
    }
    
    abstract protected function doSavePaymentProfile(PaymentProfileInterface $paymentProfile);
    
    public function removePaymentProfile(PaymentProfileInterface $paymentProfile)
    {
        $this->doRemovePaymentProfile($paymentProfile);
    }
    
    abstract protected function doRemovePaymentProfile(PaymentProfileInterface $paymentProfile);
}