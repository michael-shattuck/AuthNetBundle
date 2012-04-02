<?php

namespace Clamidity\AuthNetBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Clamidity\AuthNetBundle\Model\Transaction\TransactionInterface;

/**
 * @author Michael Shattuck <ms2474@gmail.com> 
 */
class TransactionEvent extends Event
{
    protected $transaction;

    public function __construct(TransactionInterface $transaction)
    {
        $this->transaction = $transaction;
    }

    public function getTransaction()
    {
        return $this->transaction;
    }
}
