<?php

namespace Clamidity\AuthNetBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManager;
use Clamidity\AuthNetBundle\Events;
use Clamidity\AuthNetBundle\Event\CustomerPaymentProfileEvent;
use Clamidity\AuthNetBundle\Entity\PaymentProfile;
use Clamidity\AuthNetBundle\Entity\PaymentProfileManager;

/**
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class CustomerPaymentProfileSubscriber implements EventSubscriberInterface
{
    protected $em;
    protected $securityContext;
    protected $paymentProfileManager;

    public function __construct($em, $securityContext, PaymentProfileManager $payment_profile_manager)
    {
        $this->em = $em;
        $this->securityContext = $securityContext;
        $this->paymentProfileManager = $payment_profile_manager;
    }

    public function addPaymentProfileToCustomerProfile(CustomerPaymentProfileEvent $event)
    {
        $customerProfile = $event->getCustomerProfile();
        $paymentProfileId = $event->getPaymentProfileId();
        $accountNumber = $event->getAccountNumber();

        $paymentProfile = $this->paymentProfileManager->createPaymentProfile();
        $paymentProfile->setCustomer($customerProfile);
        $paymentProfile->setPaymentProfileId($paymentProfileId);
        $paymentProfile->setAccountNumber($accountNumber);

        $this->paymentProfileManager->savePaymentProfile($paymentProfile);
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::CUSTOMER_ADD_PAYMENTPROFILE => 'addPaymentProfileToCustomerProfile',
        );
    }
}