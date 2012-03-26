<?php

namespace Clamidity\AuthNetBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManager;
use Clamidity\AuthNetBundle\Events;
use Clamidity\AuthNetBundle\Event\CustomerPaymentProfileEvent;
use Clamidity\AuthNetBundle\Entity\PaymentProfile;

/**
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class CustomerPaymentProfileSubscriber implements EventSubscriberInterface
{
    protected $em;
    protected $securityContext;

    public function __construct($em, $securityContext)
    {
        $this->em = $em;
        $this->securityContext = $securityContext;
    }

    public function addPaymentProfileToCustomerProfile(CustomerPaymentProfileEvent $event)
    {
        $customerProfile = $event->getCustomerProfile();
        $paymentProfileId = $event->getPaymentProfileId();

        $paymentProfile = new PaymentProfile();
        $paymentProfile->setCustomer($customerProfile);
        $paymentProfile->setPaymemtProfileId($paymentProfileId);

        $this->em->persist($paymentProfile);
        $this->em->flush();
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::CUSTOMER_ADD_PAYMENTPROFILE => 'addPaymentProfileToCustomerProfile',
        );
    }
}