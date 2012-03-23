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
class CustomerAddressSubscriber
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function addAddress(CustomerAddressEvent $event)
    {
        $customerProfile = $event->getCustomerProfile();
        $addressId = $event->getAddressId();

        $address = new ShippingAddress();
        $address->setCustomer($customerProfile);
        $address->setShippingAddressId($addressId);

        $this->em->persist($address);
        $this->em->flush();

        $customerProfile->addAddress($address);

        $this->em->persist($customerProfile);
        $this->em->flush();
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::CUSTOMER_ADD_ADDRESS => 'addAddress',
        );
    }
}