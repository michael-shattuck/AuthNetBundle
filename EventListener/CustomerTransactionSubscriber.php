<?php

namespace Clamidity\AuthNetBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManager;
use Clamidity\AuthNetBundle\Events;
use Clamidity\AuthNetBundle\Event\CustomerTransactionEvent;
use Clamidity\AuthNetBundle\Entity\Transaction;

/**
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class CustomerTransactionSubscriber implements EventSubscriberInterface
{
    protected $em;
    protected $securityContext;

    public function __construct($em, $securityContext)
    {
        $this->em = $em;
        $this->securityContext = $securityContext;
    }

    public function addTransactionToCustomerProfile(CustomerTransactionEvent $event)
    {
        $customerProfile = $event->getCustomerProfile();
        $transactionId = $event->getTransactionId();
        $amount = $event->getAmount();

        $transaction = new Transaction();
        $transaction->setCustomer($customerProfile);
        $transaction->setTransactionId($transactionId);
        $transaction->setAmount($amount);

        $this->em->persist($transaction);
        $this->em->flush();
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::CUSTOMER_ADD_TRANSACTION => 'addTransactionToCustomerProfile',
        );
    }
}