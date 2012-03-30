<?php

namespace Clamidity\AuthNetBundle\Model\Transaction;

use Clamidity\AuthNetBundle\Model\CustomerProfile\CustomerProfileInterface;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
interface TransactionInterface
{
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId();

    /**
     * Set TransactionId
     *
     * @param string $transactionId
     * @return AuthNetProfile
     */
    public function setTransactionId($transactionId);

    /**
     * Get TransactionId
     *
     * @return string 
     */
    public function getTransactionId();

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return AuthNetProfile
     */
    public function setCreatedAt($createdAt);

    /**
     * Get created_at
     *
     * @return datetime 
     */
    public function getCreatedAt();

    /**
     * Set modified_at
     *
     * @param datetime $modifiedAt
     * @return AuthNetProfile
     */
    public function setModifiedAt($modifiedAt);

    /**
     * Get modified_at
     *
     * @return datetime 
     */
    public function getModifiedAt();

    public function setCustomer(CustomerProfileInterface $customer);

    public function getCustomer();

    public function setAmount($amount);

    public function getAmount();
}