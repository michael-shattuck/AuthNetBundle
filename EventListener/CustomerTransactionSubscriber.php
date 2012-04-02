<?php

namespace Clamidity\AuthNetBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManager;
use Clamidity\AuthNetBundle\Events;
use Clamidity\AuthNetBundle\Event\CustomerTransactionEvent;
use Clamidity\AuthNetBundle\Entity\Transaction;
use Clamidity\AuthNetBundle\Entity\TransactionManager;

/**
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class CustomerTransactionSubscriber implements EventSubscriberInterface
{
    protected $em;
    protected $securityContext;
    protected $transactionManager;

    public function __construct($em, $securityContext, TransactionManager $transaction_manager)
    {
        $this->em = $em;
        $this->securityContext = $securityContext;
        $this->transactionManager = $transaction_manager;
    }

    public function addTransactionToCustomerProfile(CustomerTransactionEvent $event)
    {
        $customerProfile = $event->getCustomerProfile();
        $transactionId = $event->getTransactionId();
        $amount = $event->getAmount();

        $transaction = $this->transactionManager->createTransaction();
        $transaction->setCustomer($customerProfile);
        $transaction->setTransactionId($transactionId);
        $transaction->setAmount($amount);

        $this->transactionManager->saveTransaction($transaction);
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::CUSTOMER_ADD_TRANSACTION => 'addTransactionToCustomerProfile',
        );
    }
}