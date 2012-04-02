<?php

namespace Clamidity\AuthNetBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManager;
use Clamidity\AuthNetBundle\Events;
use Clamidity\AuthNetBundle\Event\CustomerAddressEvent;
use Clamidity\AuthNetBundle\Entity\ShippingAddress;
use Clamidity\AuthNetBundle\Entity\ShippingAddressManager;

/**
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class CustomerAddressSubscriber implements EventSubscriberInterface
{
    protected $em;
    protected $securityContext;
    protected $class;
    protected $shippingAddressManager;

    public function __construct($em, $securityContext, ShippingAddressManager $shipping_address_manager)
    {
        $this->em = $em;
        $this->securityContext = $securityContext;
        $this->shippingAddressManager = $shipping_address_manager;
    }

    public function addAddressToCustomerProfile(CustomerAddressEvent $event)
    {
        $customerProfile = $event->getCustomerProfile();
        $addressId = $event->getAddressId();
        $addressString = $event->getAddress();

        $address = $this->shippingAddressManager->createShippingAddress();
        $address->setCustomer($customerProfile);
        $address->setShippingAddressId($addressId);
        $address->setAddress($addressString);

        $this->shippingAddressManager->saveShippingAddress($address);
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::CUSTOMER_ADD_ADDRESS => 'addAddressToCustomerProfile',
        );
    }
}