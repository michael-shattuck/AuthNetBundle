<?php

namespace Clamidity\AuthNetBundle\Model\Transaction;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Clamidity\AuthNetBundle\Model\Transaction\TransactionManagerInterface;
use Clamidity\AuthNetBundle\Model\Transaction\TransactionInterface;
use Clamidity\AuthNetBundle\Events;
use Clamidity\AuthNetBundle\Event\TransactionEvent;

abstract class AbstractTransactionManager implements TransactionManagerInterface
{
    protected $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    
    /**
        *  Return a new (empty) Transaction entity
        * 
        *  @return Transaction
        */
    public function createTransaction()
    {
        $class = $this->getClass();
        $transaction = new $class();
//        $this->dispatcher->dispatch(Events::TRANSACTION_CREATE, new TransactionEvent($transaction));

        return $transaction;
    }
    
    /**
        * Persist a Transaction to the database
        * 
        *  @return void
        */
    public function saveTransaction(TransactionInterface $transaction)
    {
        $this->dispatcher->dispatch(Events::TRANSACTION_PRE_PERSIST, new TransactionEvent($transaction));
        $this->doSaveTransaction($transaction);
        $this->dispatcher->dispatch(Events::TRANSACTION_POST_PERSIST, new TransactionEvent($transaction));
    }
    
    abstract protected function doSaveTransaction(TransactionInterface $transaction);
    
    public function removeTransaction(TransactionInterface $transaction)
    {
        $this->doRemoveTransaction($transaction);
    }
    
    abstract protected function doRemoveTransaction(TransactionInterface $transaction);
}