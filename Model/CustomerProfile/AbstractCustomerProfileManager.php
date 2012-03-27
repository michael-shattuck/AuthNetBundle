<?php

namespace Clamidity\AuthNetBundle\Model\CustomerProfile;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Clamidity\AuthNetBundle\Model\CustomerProfile\CustomerProfileManagerInterface;
use Clamidity\AuthNetBundle\Entity\CustomerProfile;
use Clamidity\AuthNetBundle\Events;

abstract class AbstractCustomerProfileManager implements CustomerProfileManagerInterface
{
    protected $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    
    /**
        *  Return a new (empty) CustomerProfile entity
        * 
        *  @return CustomerProfile
        */
    public function createCustomerProfile()
    {
        $class = $this->getClass();
        $customerProfile = new $class();
//        $this->dispatcher->dispatch(Events::CUSTOMERPROFILE_CREATE, new CustomerProfileEvent($customerProfile));

        return $customerProfile;
    }
    
    /**
        * Persist a CustomerProfile to the database
        * 
        *  @return void
        */
    public function saveCustomerProfile(CustomerProfile $customerProfile)
    {
//        $this->dispatcher->dispatch(Events::CUSTOMERPROFILE_PRE_PERSIST, new CustomerProfileEvent($customerProfile));
        $this->doSaveCustomerProfile($customerProfile);
//        $this->dispatcher->dispatch(Events::CUSTOMERPROFILE_POST_PERSIST, new CustomerProfileEvent($customerProfile));
    }
    
    abstract protected function doSaveCustomerProfile(CustomerProfile $customerProfile);
    
    public function removeCustomerProfile(CustomerProfile $customerProfile)
    {
        $this->doRemoveCustomerProfile($customerProfile);
    }
    
    abstract protected function doRemoveCustomerProfile(CustomerProfile $customerProfile);
}