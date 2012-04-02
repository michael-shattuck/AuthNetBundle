<?php

namespace Clamidity\AuthNetBundle\Model\Transaction;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

interface TransactionManagerInterface
{
     /**
        *  Return a new (empty) Transaction entity
        * 
        *  @return Transaction
        */
    function createTransaction();
    
    /**
        * Persist a Transaction to the database
        * 
        *  @return void
        */
    function saveTransaction(TransactionInterface $transaction);
    
    /**
     * @return Transaction
     */
    function find($id);

    /**
     * @return Transaction
     * @throws NotFoundHttpException if entity is not found
     */
    function findOr404($id);

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    function findAll();

    function getClass();
}