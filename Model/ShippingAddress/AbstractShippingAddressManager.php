<?php

namespace Clamidity\AuthNetBundle\Model\ShippingAddress;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Clamidity\AuthNetBundle\Model\ShippingAddress\ShippingAddressManagerInterface;
use Clamidity\AuthNetBundle\Model\ShippingAddress\ShippingAddressInterface;
use Clamidity\AuthNetBundle\Events;
use Clamidity\AuthNetBundle\Event\ShippingAddressEvent;

abstract class AbstractShippingAddressManager implements ShippingAddressManagerInterface
{
    protected $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    
    /**
        *  Return a new (empty) ShippingAddress entity
        * 
        *  @return ShippingAddress
        */
    public function createShippingAddress()
    {
        $class = $this->getClass();
        $shippingAddress = new $class();
//        $this->dispatcher->dispatch(Events::SHIPPINGADDRESS_CREATE, new ShippingAddressEvent($shippingAddress));

        return $shippingAddress;
    }
    
    /**
        * Persist a ShippingAddress to the database
        * 
        *  @return void
        */
    public function saveShippingAddress(ShippingAddressInterface $shippingAddress)
    {
        $this->dispatcher->dispatch(Events::SHIPPINGADDRESS_PRE_PERSIST, new ShippingAddressEvent($shippingAddress));
        $this->doSaveShippingAddress($shippingAddress);
        $this->dispatcher->dispatch(Events::SHIPPINGADDRESS_POST_PERSIST, new ShippingAddressEvent($shippingAddress));
    }
    
    abstract protected function doSaveShippingAddress(ShippingAddressInterface $shippingAddress);
    
    public function removeShippingAddress(ShippingAddressInterface $shippingAddress)
    {
        $this->doRemoveShippingAddress($shippingAddress);
    }
    
    abstract protected function doRemoveShippingAddress(ShippingAddressInterface $shippingAddress);
}