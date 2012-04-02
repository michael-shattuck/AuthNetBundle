<?php

namespace Clamidity\AuthNetBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Clamidity\AuthNetBundle\Model\ShippingAddress\ShippingAddressInterface;

/**
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class ShippingAddressEvent extends Event
{
    protected $shippingAddress;

    public function __construct(ShippingAddressInterface $shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }
}
