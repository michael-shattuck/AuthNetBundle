<?php

namespace Clamidity\AuthNetBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManager;
use Clamidity\AuthNetBundle\Events;
use Clamidity\AuthNetBundle\Event\CustomerAddressEvent;
use Clamidity\AuthNetBundle\Entity\ShippingAddress;

/**
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class CustomerAddressSubscriber implements EventSubscriberInterface
{
    protected $em;
    protected $securityContext;

    public function __construct($em, $securityContext)
    {
        $this->em = $em;
        $this->securityContext = $securityContext;
    }

    public function addAddressToCustomerProfile(CustomerAddressEvent $event)
    {
        $customerProfile = $event->getCustomerProfile();
        $addressId = $event->getAddressId();

        $address = new ShippingAddress();
        $address->setCustomer($customerProfile);
        $address->setShippingAddressId($addressId);

        $this->em->persist($address);
        $this->em->flush();
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::CUSTOMER_ADD_ADDRESS => 'addAddressToCustomerProfile',
        );
    }
}